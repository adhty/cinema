<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $query = City::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->get('sort') === 'asc') {
            $query->orderBy('name', 'asc');
        } elseif ($request->get('sort') === 'desc') {
            $query->orderBy('name', 'desc');
        } else {
            $query->orderBy('name'); // default
        }

        $cities = $query->paginate(10);
        return view('admin.cities.index', compact('cities'));
    }



    public function create()
    {
        return view('admin.cities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:cities,name',
        ]);

        City::create($request->only('name'));

        return redirect()->route('admin.cities.index')->with('success', 'Kota berhasil ditambahkan.');
    }

    public function show(City $city)

    {
        return view('admin.cities.show', compact('city'));
    }

    public function edit(City $city)
    {
        return view('admin.cities.edit', compact('city'));
    }

    public function update(Request $request, City $city)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:cities,name,' . $city->id,
        ]);

        $city->update($request->only('name'));

        return redirect()->route('admin.cities.index')->with('success', 'Kota berhasil diperbarui.');
    }

    public function destroy(City $city)
    {
        $city->delete();

        return redirect()->route('admin.cities.index')->with('success', 'Kota berhasil dihapus.');
    }
}
