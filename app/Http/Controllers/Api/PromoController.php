<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        switch ($status) {
            case 'active':
                $promos = Promo::where('deadline', '>=', now()->startOfDay())->get();
                break;
            case 'expired':
                $promos = Promo::where('deadline', '<', now()->startOfDay())->get();
                break;
            case 'all':
            default:
                $promos = Promo::all();
                break;
        }

        return response()->json([
            'success' => true,
            'data' => $promos
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'deadline' => 'required|date',
            'description' => 'nullable|string',
            'term_condition' => 'nullable|string',
            'cover' => 'nullable|image|max:2048'
        ]);

        $promo = new Promo();
        $promo->title = $request->title;
        $promo->deadline = $request->deadline;
        $promo->description = $request->description;
        $promo->term_condition = $request->term_condition;

        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('promos', 'public');
            $promo->cover = $coverPath;
        }

        $promo->save();

        return response()->json([
            'success' => true,
            'data' => $promo
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Promo $promo)
    {
        return response()->json([
            'success' => true,
            'data' => $promo
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'deadline' => 'required|date',
            'description' => 'nullable|string',
            'term_condition' => 'nullable|string',
            'cover' => 'nullable|image|max:2048'
        ]);

        $promo->title = $request->title;
        $promo->deadline = $request->deadline;
        $promo->description = $request->description;
        $promo->term_condition = $request->term_condition;

        if ($request->hasFile('cover')) {
            // Delete old cover if exists
            if ($promo->cover) {
                Storage::disk('public')->delete($promo->cover);
            }

            $coverPath = $request->file('cover')->store('promos', 'public');
            $promo->cover = $coverPath;
        }

        $promo->save();

        return response()->json([
            'success' => true,
            'data' => $promo
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promo $promo)
    {
        if ($promo->cover) {
            Storage::disk('public')->delete($promo->cover);
        }

        $promo->delete();

        // 204 No Content → tanpa body JSON
        return response()->json(null, 204);
    }
}
