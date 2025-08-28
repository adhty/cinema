<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Models\Cinema;
use App\Models\Studio;
use App\Models\CinemaPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CinemaController extends BaseController
{
    public function index()
    {
        try {
            $cinemas = Cinema::with(['city', 'studios.cinemaPrice'])->get()
                ->map(fn ($c) => $this->cinemaResource($c));

            return $this->success(['cinemas' => $cinemas], 'Cinemas retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve cinemas', 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'    => 'required|string|max:255',
                'address' => 'required|string',
                'city_id' => 'required|exists:cities,id',
                'image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

                'studios' => 'nullable|array',
                'studios.*.name' => 'required_with:studios|string|max:255',
                'studios.*.type' => 'required_with:studios|in:xxi,premiere,imax',
                'studios.*.price.friday_price'  => 'nullable|integer|min:0',
                'studios.*.price.weekday_price' => 'nullable|integer|min:0',
                'studios.*.price.weekend_price' => 'nullable|integer|min:0',
            ]);

            DB::beginTransaction();

            $data = $request->only(['name', 'address', 'city_id']);

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('cinemas', 'public');
            }

            $cinema = Cinema::create($data);

            foreach ($request->input('studios', []) as $studioInput) {
                $studio = Studio::create([
                    'cinema_id' => $cinema->id,
                    'name' => $studioInput['name'],
                    'type' => $studioInput['type'],
                ]);

                CinemaPrice::create([
                    'studio_id' => $studio->id,
                    'friday_price'  => (int) data_get($studioInput, 'price.friday_price', 0),
                    'weekday_price' => (int) data_get($studioInput, 'price.weekday_price', 0),
                    'weekend_price' => (int) data_get($studioInput, 'price.weekend_price', 0),
                ]);
            }

            DB::commit();

            $cinema->load(['city', 'studios.cinemaPrice']);
            return $this->success(['cinema' => $this->cinemaResource($cinema)], 'Cinema created successfully', 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->validationError($e->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error('Failed to create cinema', 500);
        }
    }

    public function show(Cinema $cinema)
    {
        try {
            $cinema->load(['city', 'studios.cinemaPrice']);
            return $this->success(['cinema' => $this->cinemaResource($cinema)], 'Cinema retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve cinema', 500);
        }
    }

    public function update(Request $request, Cinema $cinema)
    {
        try {
            $validated = $request->validate([
                'name'    => 'required|string|max:255',
                'address' => 'required|string',
                'city_id' => 'required|exists:cities,id',
                'image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

                'studios' => 'nullable|array',
                'studios.*.id'   => 'nullable|integer|exists:studios,id',
                'studios.*.name' => 'required_with:studios|string|max:255',
                'studios.*.type' => 'required_with:studios|in:xxi,premiere,imax',

                'studios.*.price.id'            => 'nullable|integer|exists:cinema_prices,id',
                'studios.*.price.friday_price'  => 'nullable|integer|min:0',
                'studios.*.price.weekday_price' => 'nullable|integer|min:0',
                'studios.*.price.weekend_price' => 'nullable|integer|min:0',
            ]);

            DB::beginTransaction();

            $data = $request->only(['name', 'address', 'city_id']);

            if ($request->hasFile('image')) {
                if ($cinema->image && Storage::disk('public')->exists($cinema->image)) {
                    Storage::disk('public')->delete($cinema->image);
                }
                $data['image'] = $request->file('image')->store('cinemas', 'public');
            }

            $cinema->update($data);

            // Sinkronisasi studios
            $studiosInput = collect($request->input('studios', []));
            $studioIds = [];

            foreach ($studiosInput as $studioInput) {
                $studio = Studio::updateOrCreate(
                    ['id' => $studioInput['id'] ?? null],
                    [
                        'cinema_id' => $cinema->id,
                        'name' => $studioInput['name'],
                        'type' => $studioInput['type'],
                    ]
                );

                $studioIds[] = $studio->id;

                CinemaPrice::updateOrCreate(
                    ['id' => data_get($studioInput, 'price.id')],
                    [
                        'studio_id' => $studio->id,
                        'friday_price'  => (int) data_get($studioInput, 'price.friday_price', 0),
                        'weekday_price' => (int) data_get($studioInput, 'price.weekday_price', 0),
                        'weekend_price' => (int) data_get($studioInput, 'price.weekend_price', 0),
                    ]
                );
            }

            // Hapus studio yang tidak dikirim (sinkronisasi penuh)
            $cinema->studios()->whereNotIn('id', $studioIds)->delete();

            DB::commit();

            $cinema->load(['city', 'studios.cinemaPrice']);
            return $this->success(['cinema' => $this->cinemaResource($cinema)], 'Cinema updated successfully');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->validationError($e->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error('Failed to update cinema', 500);
        }
    }

    public function destroy(Cinema $cinema)
    {
        try {
            DB::beginTransaction();

            // Hapus image kalau ada
            if ($cinema->image && Storage::disk('public')->exists($cinema->image)) {
                Storage::disk('public')->delete($cinema->image);
            }

            // Hapus relasi
            foreach ($cinema->studios as $studio) {
                $studio->cinemaPrice()->delete();
                $studio->delete();
            }

            $cinema->delete();

            DB::commit();

            return response()->json(null, 204);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error('Failed to delete cinema', 500);
        }
    }

    private function cinemaResource(Cinema $cinema): array
    {
        $cinema->loadMissing(['city', 'studios.cinemaPrice']);

        $data = $cinema->toArray();
        $data['image_url'] = $cinema->image ? asset("storage/{$cinema->image}") : null;

        $labels = ['xxi' => 'Cinema XXI', 'premiere' => 'The Premiere', 'imax' => 'IMAX'];
        $types = $cinema->studios->pluck('type')->filter()->unique()->values();
        $data['available_studios'] = $types->map(fn ($t) => [
            'type' => $t,
            'label' => $labels[$t] ?? strtoupper((string) $t),
        ])->values();

        $minOf = fn (string $key): int => (int) ($cinema->studios
            ->pluck('cinemaPrice')
            ->filter()
            ->pluck($key)
            ->filter(fn ($v) => $v !== null)
            ->min() ?? 0);

        $raw = [
            'friday_price'  => $minOf('friday_price'),
            'weekday_price' => $minOf('weekday_price'),
            'weekend_price' => $minOf('weekend_price'),
        ];

        $data['price_summary'] = [
            'raw' => $raw,
            'formatted' => [
                'friday_price'  => $this->formatRupiah($raw['friday_price']),
                'weekday_price' => $this->formatRupiah($raw['weekday_price']),
                'weekend_price' => $this->formatRupiah($raw['weekend_price']),
            ],
        ];

        return $data;
    }

    private function formatRupiah(int $amount): string
    {
        return 'Rp' . number_format($amount, 0, ',', '.');
    }
}
