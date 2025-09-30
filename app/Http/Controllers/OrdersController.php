<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Seat;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        // filter by user
        $userId = $request->input('user_id');
        $payment = $request->input('payment');

        $query = Order::with(['user', 'seat']);

        if ($userId) {
            $query->where('user_id', $userId);
        }

        if ($payment) {
            $query->where('payment', $payment);
        }

        $orders = $query->latest()->paginate(10);

        // ambil list user buat filter
        $users = User::all();

        // statistik
        $stats = [
            'total'     => Order::count(),
            'pending'   => Order::where('payment', 'pending')->count(),
            'paid'      => Order::where('payment', 'paid')->count(),
            'cancelled' => Order::where('payment', 'cancelled')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'users', 'stats'));
    }
}
