<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Cinema;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $movies = Movie::with('cinema')->orderBy('title')->get();
        $cinemas = Cinema::orderBy('name')->get();

        return view('admin.movies.index', compact('movies', 'cinemas'));
    }

    public function create(Request $request)
    {
        $cinemas = Cinema::orderBy('name')->get();

        return view('admin.movies.create', compact('cinemas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'cinema_id'   => 'required|exists:cinemas,id',
        ]);

        Movie::create($request->only(['title', 'description', 'cinema_id']));

        return redirect()->route('movies.index')->with('success', 'Movie berhasil ditambahkan.');
    }

    public function show(Request $request, Movie $movie)
    {
        return view('admin.movies.show', compact('movie'));
    }

    public function edit(Request $request, Movie $movie)
    {
        $cinemas = Cinema::orderBy('name')->get();

        return view('admin.movies.edit', compact('movie', 'cinemas'));
    }

    public function update(Request $request, Movie $movie)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'cinema_id'   => 'required|exists:cinemas,id',
        ]);

        $movie->update($request->only(['title', 'description', 'cinema_id']));

        return redirect()->route('movies.index')->with('success', 'Movie berhasil diperbarui.');
    }

    public function destroy(Request $request, Movie $movie)
    {
        $movie->delete();

        return redirect()->route('movies.index')->with('success', 'Movie berhasil dihapus.');
    }
}
