<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CinemaController extends Controller
{
    public function index(Request $request)
    {
        $cinemas = Cinema::with(['city', 'studios.cinemaPrice'])->orderBy('name')->get();

        return $this->respond($request, compact('cinemas'), 'cinemas.index', compact('cinemas'));
    }

    public function create(Request $request)
    {
        $cities = City::orderBy('name')->get();
        return $this->respond($request, compact('cities'), 'cinemas.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string',
            'city_id' => 'required|exists:cities,id',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['name', 'address', 'city_id']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('cinemas', 'public');
        }

        $cinema = Cinema::create($data);

        return $this->respondWithRedirect($request, 'cinemas.index', 'Cinema berhasil ditambahkan.');
    }

    public function show(Request $request, $id)
    {
        $cinema = Cinema::with(['city', 'studios.cinemaPrice'])->findOrFail($id);

        return $this->respond($request, compact('cinema'), 'cinemas.show', compact('cinema'));
    }

    public function edit(Request $request, Cinema $cinema)
    {
        $cities = City::orderBy('name')->get();
        return $this->respond($request, compact('cinema', 'cities'), 'cinemas.edit', compact('cinema', 'cities'));
    }

    public function update(Request $request, Cinema $cinema)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string',
            'city_id' => 'required|exists:cities,id',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['name', 'address', 'city_id']);

        if ($request->hasFile('image')) {
            if ($cinema->image && Storage::disk('public')->exists($cinema->image)) {
                Storage::disk('public')->delete($cinema->image);
            }
            $data['image'] = $request->file('image')->store('cinemas', 'public');
        }

        $cinema->update($data);

        return $this->respondWithRedirect($request, 'cinemas.index', 'Cinema berhasil diperbarui.');
    }

    public function destroy(Request $request, Cinema $cinema)
    {
        if ($cinema->image && Storage::disk('public')->exists($cinema->image)) {
            Storage::disk('public')->delete($cinema->image);
        }

        $cinema->delete();

        return $this->respondWithRedirect($request, 'cinemas.index', 'Cinema berhasil dihapus.');
    }
}
