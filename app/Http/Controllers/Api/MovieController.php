<?php

namespace App\Http\Controllers\Api;

use App\Models\Movie;
use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $movies = Movie::with('actors')->get();
        return $this->respondWithSuccess($movies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'age' => 'required|integer|min:0',
            'animation_type' => 'nullable|string|max:255',
            'trailer' => 'nullable|string|max:255',
            'start_showing' => 'nullable|date',
            'start_selling' => 'nullable|date',
            'synopsis' => 'nullable|string',
            'producer' => 'nullable|string|max:255',
            'director' => 'nullable|string|max:255',
            'writer' => 'nullable|string|max:255',
            'production' => 'nullable|string|max:255',
        ]);

        $movie = Movie::create($data);

        return $this->respondWithSuccess($movie, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Movie $movie)
    {
        $movie->load('actors');
        return $this->respondWithSuccess($movie);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Movie $movie)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'age' => 'required|integer|min:0',
            'animation_type' => 'nullable|string|max:255',
            'trailer' => 'nullable|string|max:255',
            'start_showing' => 'nullable|date',
            'start_selling' => 'nullable|date',
            'synopsis' => 'nullable|string',
            'producer' => 'nullable|string|max:255',
            'director' => 'nullable|string|max:255',
            'writer' => 'nullable|string|max:255',
            'production' => 'nullable|string|max:255',
        ]);

        $movie->update($data);

        return $this->respondWithSuccess($movie);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Movie $movie)
    {
        // Delete actor photos before deleting the movie
        foreach ($movie->actors as $actor) {
            if ($actor->photo) {
                Storage::disk('public')->delete($actor->photo);
            }
        }

        $movie->delete();

        return $this->respondWithSuccess(null, 204);
    }
}