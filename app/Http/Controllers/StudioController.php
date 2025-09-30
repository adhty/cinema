<?php

namespace App\Http\Controllers;

use App\Models\Studio;
use App\Models\Cinema;
use Illuminate\Http\Request;

class StudioController extends Controller
{
    public function index(Request $request)
    {
        $studios = Studio::with(['cinema'])->orderBy('name')->get();
        $cinemas = Cinema::orderBy('name')->get();

        return view('admin.studios.index', compact('studios', 'cinemas'));
    }

    public function create(Request $request)
    {
        $cinemas = Cinema::orderBy('name')->get();

        return view('admin.studios.create', compact('cinemas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'cinema_id' => 'required|exists:cinemas,id',
        ]);

        Studio::create($request->only(['name', 'cinema_id']));

        return redirect()->route('studios.index')->with('success', 'Studio berhasil ditambahkan.');
    }

    public function show(Request $request, $id)
    {
        $studio = Studio::with('cinema')->findOrFail($id);

        return view('admin.studios.show', compact('studio'));
    }

    public function edit(Request $request, Studio $studio)
    {
        $cinemas = Cinema::orderBy('name')->get();

        return view('admin.studios.edit', compact('studio', 'cinemas'));
    }

    public function update(Request $request, Studio $studio)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'cinema_id' => 'required|exists:cinemas,id',
        ]);

        $studio->update($request->only(['name', 'cinema_id']));

        return redirect()->route('studios.index')->with('success', 'Studio berhasil diperbarui.');
    }

    public function destroy(Request $request, Studio $studio)
    {
        $studio->delete();

        return redirect()->route('studios.index')->with('success', 'Studio berhasil dihapus.');
    }
}
