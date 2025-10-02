<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Movie;
use App\Models\Seats;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    // List all orders
    public function index(Request $request)
    {
        $query = Order::with(['user', 'seats', 'movie']);

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('payment')) {
            $query->where('payment', $request->payment);
        }

        $orders = $query->latest()->paginate(10);
        $users = User::select('id', 'name', 'email')->get();

        $stats = [
            'total'     => Order::count(),
            'pending'   => Order::where('payment', 'pending')->count(),
            'paid'      => Order::where('payment', 'paid')->count(),
            'cancelled' => Order::where('payment', 'cancelled')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'users', 'stats'));
    }

    // Show form to create booking
    public function create($movie_id)
    {
        $movie = Movie::findOrFail($movie_id);
        $seats = Seats::where('movie_id', $movie_id)
            ->where('status', 'available')
            ->get();

        return view('orders.create', compact('movie', 'seats'));
    }

    // Store new order + book seats
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'  => 'required|exists:users,id',
            'movie_id' => 'required|exists:movies,id',
            'seats'    => 'required|array|min:1',
            'seats.*'  => 'exists:seats,id',
        ]);

        DB::transaction(function () use ($validated) {
            $order = Order::create([
                'user_id'  => $validated['user_id'],
                'movie_id' => $validated['movie_id'],
                'payment'  => 'pending',
            ]);

            foreach ($validated['seats'] as $seatId) {
                $seat = Seats::find($seatId);
                if ($seat && $seat->status == 'available') {
                    $seat->status = 'booked';
                    $seat->order_id = $order->id;
                    $seat->save();
                } else {
                    throw new \Exception("Seat {$seat->number} sudah dibooking!");
                }
            }
        });

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order berhasil ditambahkan!');
    }

    // Show detail order
    public function show(Order $order)
    {
        $order->load(['user', 'seats', 'movie']);
        return view('admin.orders.show', compact('order'));
    }

    // Edit order payment status
    public function edit(Order $order)
    {
        $users = User::orderBy('name')->get();
        $movies = Movie::orderBy('title')->get();
        $seats = Seats::orderBy('id')->get();

        return view('admin.orders.edit', compact('order', 'users', 'movies', 'seats'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'payment' => 'required|in:pending,paid,cancelled',
        ]);

        $order->update($data);

        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil diperbarui');
    }

    // Delete order + free seats
    public function destroy(Order $order)
    {
        foreach ($order->seats as $seat) {
            $seat->status = 'available';
            $seat->order_id = null;
            $seat->save();
        }

        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil dihapus');
    }

    // API: get booked seat ids for a movie
    public function availableSeats(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id'
        ]);

        $bookedSeatIds = Seast::where('movie_id', $request->movie_id)
            ->where('status', 'booked')
            ->pluck('id')
            ->toArray();

        return response()->json($bookedSeatIds);
    }
}
