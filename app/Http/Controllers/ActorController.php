<?php
namespace App\Http\Controllers;
 
use App\Models\Movie;
use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
 
class ActorController extends Controller
{
    public function index(Request $request)
    {
        $actors = Actor::all();
        return $this->respond($request, $actors);
    }
    
    public function create(Request $request, Movie $movie)
    {
        $data = compact('movie');
        return $this->respond($request, $data, 'movies.actors.create', $data);
    }
 
    public function store(Request $request)
    {
        $data = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'name' => 'required|string|max:255',
            'character_name' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'photo.image' => 'The file must be an image.',
            'photo.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'photo.max' => 'The image may not be greater than 2048 kilobytes.',
        ]);
 
        $movie = Movie::findOrFail($request->movie_id);
 
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('actors', 'public');
        }
 
        $actor = $movie->actors()->create($data);
 
        return $this->respondWithRedirect($request, 'movies.show', 'Actor added successfully!', 'success', ['id' => $movie->id]);
    }
 
    public function show(Request $request, Actor $actor)
    {
        return $this->respond($request, $actor);
    }
 
    public function edit(Request $request, Movie $movie, Actor $actor)
    {
        $data = compact('movie', 'actor');
        return $this->respond($request, $data, 'movies.actors.edit', $data);
    }
 
    public function update(Request $request, Actor $actor)
    {
        $data = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'name' => 'required|string|max:255',
            'character_name' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'photo.image' => 'The file must be an image.',
            'photo.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'photo.max' => 'The image may not be greater than 2048 kilobytes.',
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
 
        return $this->respondWithRedirect($request, 'movies.show', 'Actor updated successfully!', 'success', ['id' => $movie->id]);
    }
 
    public function destroy(Request $request, Actor $actor)
    {
        // Get the movie ID before deleting the actor
        $movieId = $actor->movie_id;
        
        // Delete the actor's photo if it exists
        if ($actor->photo) {
            Storage::disk('public')->delete($actor->photo);
        }
        
        $actor->delete();
        return $this->respondWithRedirect($request, 'movies.show', 'Actor deleted successfully!', 'success', ['id' => $movieId]);
    }
}
