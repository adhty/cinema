<?php

namespace App\Http\Controllers\Api;

use App\Models\Studio;
use App\Models\Cinema;
use App\Models\CinemaPrice;
use Illuminate\Http\Request;

class StudioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $studios = Studio::with(['cinema','cinemaPrice'])->get();
        return $this->respondWithSuccess($studios);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'cinema_id' => 'required|exists:cinemas,id',
            'name' => 'required|string|max:255',
            'weekday_price' => 'required|integer|min:0',
            'friday_price' => 'required|integer|min:0',
            'weekend_price' => 'required|integer|min:0',
        ]);

        $studio = Studio::create($request->only(['cinema_id', 'name']));

        $price = CinemaPrice::create([
            'studio_id' => $studio->id,
            'weekday_price' => (int) $request->input('weekday_price', 0),
            'friday_price' => (int) $request->input('friday_price', 0),
            'weekend_price' => (int) $request->input('weekend_price', 0),
        ]);

        $studio->load(['cinema','cinemaPrice']);

        return $this->respondWithSuccess($studio, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Studio  $studio
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Studio $studio)
    {
        $studio->load(['cinema','cinemaPrice']);
        return $this->respondWithSuccess($studio);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Studio  $studio
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Studio $studio)
    {
        $request->validate([
            'cinema_id' => 'required|exists:cinemas,id',
            'name' => 'required|string|max:255',
            'weekday_price' => 'required|integer|min:0',
            'friday_price' => 'required|integer|min:0',
            'weekend_price' => 'required|integer|min:0',
        ]);

        $studio->update($request->only(['cinema_id', 'name']));

        $price = CinemaPrice::firstOrNew(['studio_id' => $studio->id]);
        $price->studio_id = $studio->id;
        $price->weekday_price = (int) $request->input('weekday_price', 0);
        $price->friday_price = (int) $request->input('friday_price', 0);
        $price->weekend_price = (int) $request->input('weekend_price', 0);
        $price->save();

        $studio->load(['cinema','cinemaPrice']);

        return $this->respondWithSuccess($studio);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Studio  $studio
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Studio $studio)
    {
        $studio->delete();

        return $this->respondWithSuccess(null, 204);
    }
}