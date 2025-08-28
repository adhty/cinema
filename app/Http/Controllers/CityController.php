<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $cities = City::all();
        return $this->respond($request, $cities, 'cities.index', compact('cities'));
    }

    public function create(Request $request)
    {
        return $this->respond($request, null, 'cities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $city = City::create($request->all());
        return $this->respondWithRedirect($request, 'cities.index', 'City berhasil ditambahkan.');
    }

    public function show(Request $request, City $city)
    {
        return $this->respond($request, $city);
    }

    public function edit(Request $request, City $city)
    {
        return $this->respond($request, $city, 'cities.edit', compact('city'));
    }

    public function update(Request $request, City $city)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $city->update($request->all());
        return $this->respondWithRedirect($request, 'cities.index', 'City berhasil diupdate.');
    }

    public function destroy(Request $request, City $city)
    {
        $city->delete();
        return $this->respondWithRedirect($request, 'cities.index', 'City berhasil dihapus.');
    }
}
