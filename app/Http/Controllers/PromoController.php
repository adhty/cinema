<?php
 
namespace App\Http\Controllers;
 
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
                $promos = Promo::where('deadline', '>=', now())->get();
                break;
            case 'expired':
                $promos = Promo::where('deadline', '<', now())->get();
                break;
            case 'all':
            default:
                $promos = Promo::all();
                break;
        }
        
        $data = compact('promos', 'status');
        return $this->respond($request, $data, 'promos.index', $data);
    }
 
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return $this->respond($request, null, 'promos.create');
    }
 
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
            'deadline' => 'required|date',
            'description' => 'nullable|string',
            'term_condition' => 'nullable|string',
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
 
        return $this->respondWithRedirect($request, 'promos.index', 'Promo created successfully.');
    }
 
    /**
     * Display the specified resource.
     */
    public function show(Request $request, Promo $promo)
    {
        $data = compact('promo');
        return $this->respond($request, $data, 'promos.show', $data);
    }
 
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Promo $promo)
    {
        $data = compact('promo');
        return $this->respond($request, $data, 'promos.edit', $data);
    }
 
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
            'deadline' => 'required|date',
            'description' => 'nullable|string',
            'term_condition' => 'nullable|string',
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
 
        return $this->respondWithRedirect($request, 'promos.index', 'Promo updated successfully.');
    }
 
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Promo $promo)
    {
        // Delete cover if exists
        if ($promo->cover) {
            Storage::disk('public')->delete($promo->cover);
        }
        
        $promo->delete();
        return $this->respondWithRedirect($request, 'promos.index', 'Promo deleted successfully.');
    }
}