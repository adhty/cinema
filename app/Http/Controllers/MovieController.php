<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Cinema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function index()
    {
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
            'title' => 'required|string|max:255',
            'duration' => 'required|integer',
            'age' => 'required|integer',
            'animation_type' => 'nullable|string|max:100',
            'trailer' => 'nullable|url',
            'start_showing' => 'required|date',
            'start_selling' => 'required|date',
            'synopsis' => 'nullable|string',
            'producer' => 'nullable|string|max:255',
            'director' => 'nullable|string|max:255',
            'writer' => 'nullable|string|max:255',
            'production' => 'nullable|string|max:255',
            'cinemas' => 'array',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // ✅ tambahin validasi cover
        ]);

        // 1️⃣ Buat movie dulu
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
            'production'
        ]));

        // 2️⃣ Simpan file cover (kalau ada)
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public');
            $movie->cover = $coverPath;
            $movie->save(); // jangan lupa save setelah update cover
        }

        // 3️⃣ Simpan relasi cinema
        if ($request->has('cinemas')) {
            $movie->cinemas()->sync($request->cinemas);
        }

        return redirect()->route('admin.movies.index')->with('success', 'Movie berhasil ditambahkan.');
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
            'title' => 'required|string|max:255',
            'duration' => 'required|integer',
            'age' => 'required|integer',
            'animation_type' => 'nullable|string|max:100',
            'trailer' => 'nullable|url',
            'start_showing' => 'required|date',
            'start_selling' => 'required|date',
            'synopsis' => 'nullable|string',
            'producer' => 'nullable|string|max:255',
            'director' => 'nullable|string|max:255',
            'writer' => 'nullable|string|max:255',
            'production' => 'nullable|string|max:255',
            'cinemas' => 'array',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // validasi cover
        ]);

        // Update data utama
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
            'production'
        ]));

        // Update cover baru (hapus lama kalau ada)
        if ($request->hasFile('cover')) {
            if ($movie->cover && Storage::disk('public')->exists($movie->cover)) {
                Storage::disk('public')->delete($movie->cover);
            }

            $coverPath = $request->file('cover')->store('covers', 'public');
            $movie->cover = $coverPath;
            $movie->save();
        }


        // Update relasi cinema
        if ($request->has('cinemas')) {
            $movie->cinemas()->sync($request->cinemas);
        }

        return redirect()->route('admin.movies.index')->with('success', 'Movie berhasil diperbarui.');
    }


    public function destroy(Movie $movie)
    {
        // hapus file cover dari storage
        if ($movie->cover && Storage::disk('public')->exists($movie->cover)) {
            Storage::disk('public')->delete($movie->cover);
        }

        $movie->cinemas()->detach();
        $movie->delete();

        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie berhasil dihapus.');
    }
}
