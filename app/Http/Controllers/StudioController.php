<?php
 
namespace App\Http\Controllers;
 
use App\Models\Studio;
use App\Models\Cinema;
use App\Models\CinemaPrice;
use Illuminate\Http\Request;
 
class StudioController extends Controller
{
    /**
     * Tampilkan semua studio
     */
    public function index(Request $request)
    {
        $studios = Studio::with(['cinema','cinemaPrice'])->get();
        $data = compact('studios');
        return $this->respond($request, $data, 'studios.index', $data);
    }
 
    /**
     * Form tambah studio
     */
    public function create(Request $request)
    {
        $cinemas = Cinema::all();
        $data = compact('cinemas');
        return $this->respond($request, $data, 'studios.create', $data);
    }
 
    /**
     * Simpan studio baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'cinema_id' => 'required|exists:cinemas,id',
            'name' => 'required|string|max:255',
            'weekday_price' => 'required|integer|min:0',
            'friday_price' => 'required|integer|min:0',
            'weekend_price' => 'required|integer|min:0',
        ]);

        $studio = Studio::create($request->only(['cinema_id', 'name']));

        CinemaPrice::create([
            'studio_id' => $studio->id,
            'weekday_price' => (int) $request->input('weekday_price', 0),
            'friday_price' => (int) $request->input('friday_price', 0),
            'weekend_price' => (int) $request->input('weekend_price', 0),
        ]);

        return $this->respondWithRedirect($request, 'studios.index', 'Studio berhasil ditambahkan.');
    }
 
    /**
     * Tampilkan detail studio
     */
    public function show(Request $request, Studio $studio)
    {
        $cinemas = Cinema::all();
        $data = compact('studio', 'cinemas');
        return $this->respond($request, $data);
    }
 
    /**
     * Tampilkan form edit studio
     */
    public function edit(Request $request, Studio $studio)
    {
        $cinemas = Cinema::all();
        $studio->load('cinemaPrice');
        $data = compact('studio', 'cinemas');
        return $this->respond($request, $data, 'studios.edit', $data);
    }
 
    /**
     * Update data studio
     */
    public function update(Request $request, Studio $studio)
    {
        $request->validate([
            'cinema_id' => 'required|exists:cinemas,id',
            'name' => 'required|string|max:255',
            'weekday_price' => 'required|integer|min:0',
            'friday_price' => 'required|integer|min:0',
            'weekend_price' => 'required|integer|min:0',
        ]);

        $studio->update($request->only(['cinema_id', 'name']));

        $price = CinemaPrice::firstOrNew(['studio_id' => $studio->id]);
        $price->studio_id = $studio->id;
        $price->weekday_price = (int) $request->input('weekday_price', 0);
        $price->friday_price = (int) $request->input('friday_price', 0);
        $price->weekend_price = (int) $request->input('weekend_price', 0);
        $price->save();

        return $this->respondWithRedirect($request, 'studios.index', 'Studio berhasil diperbarui.');
    }
 
    /**
     * Hapus studio
     */
    public function destroy(Request $request, Studio $studio)
    {
        $studio->delete();
        return $this->respondWithRedirect($request, 'studios.index', 'Studio berhasil dihapus.');
    }
}
