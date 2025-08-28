<?php
 
namespace App\Http\Controllers;
 
use App\Models\Movie;
use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
 
class MovieController extends Controller
{
    public function index(Request $request)
    {
        $movies = Movie::with('actors')->get();
        $data = compact('movies');
        return $this->respond($request, $data, 'movies.index', $data);
    }
 
    public function create(Request $request)
    {
        $movie = new Movie();
        $data = compact('movie');
        return $this->respond($request, $data, 'movies.create', $data);
    }
 
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
            'actors' => 'nullable|array',
            'actors.*.name' => 'required|string|max:255',
            'actors.*.character_name' => 'nullable|string|max:255',
            'actors.*.photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'actors.*.photo.image' => 'The actor photo must be an image.',
            'actors.*.photo.mimes' => 'The actor photo must be a file of type: jpeg, png, jpg, gif.',
            'actors.*.photo.max' => 'The actor photo may not be greater than 2048 kilobytes.',
        ]);
 
        $movie = Movie::create($data);
        
        // Handle actors data
        if ($request->has('actors')) {
            foreach ($request->actors as $actorData) {
                if (!empty($actorData['name'])) {
                    $actor = new Actor();
                    $actor->movie_id = $movie->id;
                    $actor->name = $actorData['name'];
                    $actor->character_name = $actorData['character_name'] ?? null;
                    
                    // Handle photo upload
                    if (isset($actorData['photo']) && $actorData['photo']->isValid()) {
                        $actor->photo = $actorData['photo']->store('actors', 'public');
                    }
                    
                    $actor->save();
                }
            }
        }
        
        return $this->respondWithRedirect($request, 'movies.index', 'Movie created successfully!');
    }
 
    public function show(Request $request, Movie $movie)
    {
        $movie->load('actors');
        $data = compact('movie');
        return $this->respond($request, $data, 'movies.show', $data);
    }
 
    public function edit(Request $request, Movie $movie)
    {
        $data = compact('movie');
        return $this->respond($request, $data, 'movies.edit', $data);
    }
 
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
            'actors' => 'nullable|array',
            'actors.*.name' => 'required|string|max:255',
            'actors.*.character_name' => 'nullable|string|max:255',
            'actors.*.photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'actors.*.photo.image' => 'The actor photo must be an image.',
            'actors.*.photo.mimes' => 'The actor photo must be a file of type: jpeg, png, jpg, gif.',
            'actors.*.photo.max' => 'The actor photo may not be greater than 2048 kilobytes.',
        ]);
 
        $movie->update($data);
        
        // Handle actors data
        if ($request->has('actors')) {
            // First, delete existing actors that are not in the new list (if any)
            $existingActorIds = [];
            foreach ($request->actors as $index => $actorData) {
                if (isset($actorData['id'])) {
                    $existingActorIds[] = $actorData['id'];
                }
            }
            
            // Delete actors that are not in the new list (if any)
            $movie->actors()->whereNotIn('id', $existingActorIds)->delete();
            
            // Process actors data
            foreach ($request->actors as $index => $actorData) {
                if (!empty($actorData['name'])) {
                    if (isset($actorData['id'])) {
                        // Update existing actor
                        $actor = Actor::find($actorData['id']);
                        if ($actor) {
                            $oldPhoto = $actor->photo;
                            $actor->name = $actorData['name'];
                            $actor->character_name = $actorData['character_name'] ?? null;
                            
                            // Handle photo upload
                            if (isset($actorData['photo']) && $actorData['photo']->isValid()) {
                                // Delete old photo if exists
                                if ($oldPhoto) {
                                    Storage::disk('public')->delete($oldPhoto);
                                }
                                $actor->photo = $actorData['photo']->store('actors', 'public');
                            }
                            $actor->save();
                        }
                    } else {
                        // Create new actor
                        $actor = new Actor();
                        $actor->movie_id = $movie->id;
                        $actor->name = $actorData['name'];
                        $actor->character_name = $actorData['character_name'] ?? null;
                        
                        // Handle photo upload
                        if (isset($actorData['photo']) && $actorData['photo']->isValid()) {
                            $actor->photo = $actorData['photo']->store('actors', 'public');
                        }
                        $actor->save();
                    }
                }
            }
        }
        
        return $this->respondWithRedirect($request, 'movies.index', 'Movie updated successfully!');
    }
 
    public function destroy(Request $request, Movie $movie)
    {
        // Delete actor photos before deleting the movie
        foreach ($movie->actors as $actor) {
            if ($actor->photo) {
                Storage::disk('public')->delete($actor->photo);
            }
        }
        
        $movie->delete();
        return $this->respondWithRedirect($request, 'movies.index', 'Movie deleted successfully!');
    }
}
