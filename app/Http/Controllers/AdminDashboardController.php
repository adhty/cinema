<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Promo;

class AdminDashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin
     */
    public function index()
    {
        // Ambil semua kota
        $cities = City::orderBy('name')->get();

        // Ambil data promo terbaru (opsional)
        $promos = Promo::orderBy('created_at', 'desc')->take(5)->get();

        // Kirim data ke view
        return view('admin.dashboard', compact('cities', 'promos'));
    }
}
