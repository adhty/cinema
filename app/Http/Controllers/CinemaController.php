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
        $cinemas = Cinema::with(['city', 'studios.cinemaPrice'])
            ->orderBy('name')
            ->get();

        $cities = City::orderBy('name')->get();

        return view('admin.cinemas.index', compact('cinemas', 'cities'));
    }

    public function create(Request $request)
    {
        $cities = City::orderBy('name')->get();

        return view('admin.cinemas.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string',
            'city_id' => 'required|exists:cities,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        ]);

        $data = $request->only(['name', 'address', 'city_id']);

        if ($request->hasFile('cover')) {
            $data['image'] = $request->file('cover')->store('cinemas', 'public');
        }

        Cinema::create($data);

        return redirect()->route('admin.cinemas.index')->with('success', 'Cinema berhasil ditambahkan.');
    }

    public function show(Request $request, $id)
    {
        $cinema = Cinema::with(['city', 'studios.cinemaPrice'])->findOrFail($id);

        return view('admin.cinemas.show', compact('cinema'));
    }

    public function edit(Request $request, Cinema $cinema)
    {
        $cities = City::orderBy('name')->get();

        return view('admin.cinemas.edit', compact('cinema', 'cities'));
    }

    public function update(Request $request, Cinema $cinema)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string',
            'city_id' => 'required|exists:cities,id',
            'cover'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['name', 'address', 'city_id']);

        if ($request->hasFile('cover')) {
            if ($cinema->image && Storage::disk('public')->exists($cinema->image)) {
                Storage::disk('public')->delete($cinema->image);
            }
            $data['image'] = $request->file('cover')->store('cinemas', 'public');
        }

        $cinema->update($data);

        return redirect()->route('admin.cinemas.index')->with('success', 'Cinema berhasil diperbarui.');
    }

    public function destroy(Request $request, Cinema $cinema)
    {
        if ($cinema->image && Storage::disk('public')->exists($cinema->image)) {
            Storage::disk('public')->delete($cinema->image);
        }

        $cinema->delete();

        return redirect()->route('admin.cinemas.index')->with('success', 'Cinema berhasil dihapus.');
    }
}
