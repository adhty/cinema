<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends BaseController
{
    public function index()
    {
        try {
            $cities = City::orderBy('name')->get();
            return $this->success(['cities' => $cities], 'Cities retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve cities', 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:cities,name',
            ]);

            $city = City::create($validated);

            return $this->success(['city' => $city], 'City created successfully', 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->validationError($e->errors());
        } catch (\Exception $e) {
            return $this->error('Failed to create city', 500);
        }
    }

    public function show(City $city)
    {
        try {
            $city->load(['cinemas']);
            return $this->success(['city' => $city], 'City retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve city', 500);
        }
    }

    public function update(Request $request, City $city)
    {
        try {
            $validated = $request->validate([
                'name' => "required|string|max:255|unique:cities,name,{$city->id}",
            ]);

            $city->update($validated);

            return $this->success(['city' => $city], 'City updated successfully');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->validationError($e->errors());
        } catch (\Exception $e) {
            return $this->error('Failed to update city', 500);
        }
    }

    public function destroy(City $city)
    {
        try {
            // Check if city has cinemas
            if ($city->cinemas()->count() > 0) {
                return $this->error('Cannot delete city that has cinemas', 400);
            }

            $city->delete();

            return response()->json(null, 204);

        } catch (\Exception $e) {
            return $this->error('Failed to delete city', 500);
        }
    }
}
