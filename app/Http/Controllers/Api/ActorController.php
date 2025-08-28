<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Models\Actor;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ActorController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $actors = Actor::all();
        return $this->respondWithSuccess($actors);
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
            'movie_id' => 'required|exists:movies,id',
            'name' => 'required|string|max:255',
            'character_name' => 'nullable|string|max:255',
        ]);

        $movie = Movie::findOrFail($request->movie_id);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('actors', 'public');
        }

        $actor = $movie->actors()->create($data);

        return $this->respondWithSuccess($actor, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Actor  $actor
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Actor $actor)
    {
        return $this->respondWithSuccess($actor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Actor  $actor
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Actor $actor)
    {
        $data = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'name' => 'required|string|max:255',
            'character_name' => 'nullable|string|max:255',
        ]);

        $movie = Movie::findOrFail($request->movie_id);

        // Store the old photo path to delete it later if a new photo is uploaded
        $oldPhoto = $actor->photo;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('actors', 'public');
        }

        $actor->update($data);

        // Delete the old photo if a new one was uploaded
        if ($request->hasFile('photo') && $oldPhoto) {
            Storage::disk('public')->delete($oldPhoto);
        }

        return $this->respondWithSuccess($actor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Actor  $actor
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Actor $actor)
    {
        // Delete the actor's photo if it exists
        if ($actor->photo) {
            Storage::disk('public')->delete($actor->photo);
        }

        $actor->delete();

        return $this->respondWithSuccess(null, 204);
    }
}