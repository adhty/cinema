<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Models\Movie;
use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MovieController extends BaseController
{
    public function index()
    {
        try {
            $movies = Movie::with('actors')->orderBy('title')->get();
            return $this->success(['movies' => $movies], 'Movies retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve movies', 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'duration' => 'required|integer|min:1',
                'age' => 'required|integer|min:0',
                'animation_type' => 'nullable|string|max:255',
                'trailer' => 'nullable|url',
                'start_showing' => 'nullable|date',
                'start_selling' => 'nullable|date',
                'synopsis' => 'nullable|string',
                'producer' => 'nullable|string|max:255',
                'director' => 'nullable|string|max:255',
                'writer' => 'nullable|string|max:255',
                'production' => 'nullable|string|max:255',
            ]);

            $movie = Movie::create($validated);

            return $this->success(['movie' => $movie], 'Movie created successfully', 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->validationError($e->errors());
        } catch (\Exception $e) {
            return $this->error('Failed to create movie', 500);
        }
    }

    public function show(Movie $movie)
    {
        try {
            $movie->load('actors');
            return $this->success(['movie' => $movie], 'Movie retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve movie', 500);
        }
    }

    public function update(Request $request, Movie $movie)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'duration' => 'required|integer|min:1',
                'age' => 'required|integer|min:0',
                'animation_type' => 'nullable|string|max:255',
                'trailer' => 'nullable|url',
                'start_showing' => 'nullable|date',
                'start_selling' => 'nullable|date',
                'synopsis' => 'nullable|string',
                'producer' => 'nullable|string|max:255',
                'director' => 'nullable|string|max:255',
                'writer' => 'nullable|string|max:255',
                'production' => 'nullable|string|max:255',
            ]);

            $movie->update($validated);

            return $this->success(['movie' => $movie], 'Movie updated successfully');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->validationError($e->errors());
        } catch (\Exception $e) {
            return $this->error('Failed to update movie', 500);
        }
    }

    public function destroy(Movie $movie)
    {
        try {
            DB::beginTransaction();

            // Delete actor photos before deleting the movie
            foreach ($movie->actors as $actor) {
                if ($actor->photo && Storage::disk('public')->exists($actor->photo)) {
                    Storage::disk('public')->delete($actor->photo);
                }
            }

            $movie->delete();

            DB::commit();

            return response()->json(null, 204);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error('Failed to delete movie', 500);
        }
    }
}