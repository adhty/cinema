<?php

namespace App\Http\Controllers;

use App\Models\City;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $cities = City::orderBy('name')->get();
        return view('admin.dashboard', compact('cities'));
    }
}
