<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller; // <-- penting jangan lupa
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::all();
        return response()->json([
            'success' => true,
            'data' => $cities
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $city = City::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $city
        ], 201);
    }

    public function show(City $city)
    {
        return response()->json([
            'success' => true,
            'data' => $city
        ], 200);
    }

    public function update(Request $request, City $city)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $city->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $city
        ], 200);
    }

    public function destroy(City $city)
    {
        $city->delete();

        return response()->json([
            'success' => true,
            'message' => 'City deleted successfully'
        ], 200);
    }
}
