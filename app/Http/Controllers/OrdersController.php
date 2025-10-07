<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Seat;
use App\Models\Seats;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    // 🔹 List semua order
    public function index(Request $request)
    {
        $query = Order::with(['user', 'seat.ticket.movie']);

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('payment')) {
            $query->where('payment', $request->payment);
        }

        $orders = $query->latest()->paginate(10);
        $users  = User::select('id', 'name', 'email')->get();

        $stats = [
            'total'     => Order::count(),
            'pending'   => Order::where('payment', 'pending')->count(),
            'paid'      => Order::where('payment', 'paid')->count(),
            'cancelled' => Order::where('payment', 'cancelled')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'users', 'stats'));
    }

    // 🔹 Form untuk membuat order manual (opsional)
    public function create()
    {
        $tickets = Ticket::with('movie')->get();
        $users   = User::all();
        $seats   = Seats::where('status', 'available')->get();

        return view('admin.orders.create', compact('tickets', 'users', 'seats'));
    }

    // 🔹 Simpan order baru + ubah kursi jadi booked
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'seat_ids' => 'required|array',
            'seat_ids.*' => 'exists:seats,id'
        ]);

        foreach ($request->seat_ids as $seatId) {
            Order::create([
                'user_id' => $request->user_id,
                'seat_id' => $seatId
            ]);

            // update status kursi
            Seats::where('id', $seatId)->update(['status' => 'booked']);
        }

        return response()->json(['success' => true]);
    }


    // 🔹 Detail order
    public function show(Order $order)
    {
        $order->load(['user', 'seat.ticket.movie']);
        return view('admin.orders.show', compact('order'));
    }

    // 🔹 Edit status pembayaran
    public function edit(Order $order)
    {
        $users   = User::orderBy('name')->get();
        $tickets = Ticket::orderBy('date')->get();

        return view('admin.orders.edit', compact('order', 'users', 'tickets'));
    }

    // 🔹 Update status pembayaran
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'payment' => 'required|in:pending,paid,cancelled',
        ]);

        $order->update($data);

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Status pembayaran diperbarui.');
    }

    // 🔹 Hapus order dan bebaskan kursinya
    public function destroy(Order $order)
    {
        if ($order->seat) {
            $order->seat->update([
                'status'   => 'available',
                'order_id' => null,
            ]);
        }

        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order berhasil dihapus!');
    }

    // 🔹 API: ambil kursi yang sudah dibooking per tiket
    public function availableSeats(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
        ]);

        $bookedSeatIds = Seats::where('ticket_id', $request->ticket_id)
            ->where('status', 'booked')
            ->pluck('id')
            ->toArray();

        return response()->json($bookedSeatIds);
    }
}
