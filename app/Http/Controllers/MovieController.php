<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Cinema;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        // ganti 'cinema' jadi 'cinemas'
        $movies = Movie::with('cinemas')->orderBy('title')->get();
        $cinemas = Cinema::orderBy('name')->get();

        return view('admin.movies.index', compact('movies', 'cinemas'));
    }

    public function create()
    {
        $cinemas = Cinema::orderBy('name')->get();
        return view('admin.movies.create', compact('cinemas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'duration'       => 'required|integer',
            'age'            => 'required|integer',
            'animation_type' => 'nullable|string|max:100',
            'trailer'        => 'nullable|url',
            'start_showing'  => 'required|date',
            'start_selling'  => 'required|date',
            'synopsis'       => 'nullable|string',
            'producer'       => 'nullable|string|max:255',
            'director'       => 'nullable|string|max:255',
            'writer'         => 'nullable|string|max:255',
            'production'     => 'nullable|string|max:255',
            'cinemas'        => 'array' // ✅ validasi untuk relasi cinema
        ]);

        $movie = Movie::create($request->only([
            'title',
            'duration',
            'age',
            'animation_type',
            'trailer',
            'start_showing',
            'start_selling',
            'synopsis',
            'producer',
            'director',
            'writer',
            'production',
        ]));

        // ✅ simpan relasi cinema (pivot)
        if ($request->has('cinemas')) {
            $movie->cinemas()->sync($request->cinemas);
        }

        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie berhasil ditambahkan.');
    }

    public function show(Movie $movie)
    {
        return view('admin.movies.show', compact('movie'));
    }

    public function edit(Movie $movie)
    {
        $cinemas = Cinema::orderBy('name')->get();
        return view('admin.movies.edit', compact('movie', 'cinemas'));
    }

    public function update(Request $request, Movie $movie)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'duration'       => 'required|integer',
            'age'            => 'required|integer',
            'animation_type' => 'nullable|string|max:100',
            'trailer'        => 'nullable|url',
            'start_showing'  => 'required|date',
            'start_selling'  => 'required|date',
            'synopsis'       => 'nullable|string',
            'producer'       => 'nullable|string|max:255',
            'director'       => 'nullable|string|max:255',
            'writer'         => 'nullable|string|max:255',
            'production'     => 'nullable|string|max:255',
            'cinemas'        => 'array' // ✅ validasi relasi cinema
        ]);

        $movie->update($request->only([
            'title',
            'duration',
            'age',
            'animation_type',
            'trailer',
            'start_showing',
            'start_selling',
            'synopsis',
            'producer',
            'director',
            'writer',
            'production',
        ]));

        // ✅ update pivot table
        if ($request->has('cinemas')) {
            $movie->cinemas()->sync($request->cinemas);
        }

        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie berhasil diperbarui.');
    }

    public function destroy(Movie $movie)
    {
        $movie->cinemas()->detach(); // ✅ hapus relasi pivot dulu
        $movie->delete();

        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie berhasil dihapus.');
    }
}
