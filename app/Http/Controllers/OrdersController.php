<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Seats;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    // List semua order
    public function index(Request $request)
    {
        $query = Order::with(['user', 'seat.ticket.movie', 'seat.ticket.cinema', 'seat.ticket.studio']);

        // Filter by user if provided
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by payment status if provided
        if ($request->has('payment') && $request->payment) {
            $query->where('payment', $request->payment);
        }

        $orders = $query->latest()->paginate(20);

        // Get all users for filter dropdown
        $users = User::orderBy('name')->get();

        return view('orders.index', compact('orders', 'users'));
    }

    // Detail order tertentu
    public function show($id)
    {
        $order = Order::with(['user', 'seat.ticket.movie', 'seat.ticket.cinema', 'seat.ticket.studio'])
            ->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    // Update payment status
    public function updatePayment(Request $request, $id)
    {
        $request->validate([
            'payment' => 'required|in:pending,paid,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->update(['payment' => $request->payment]);

        // If cancelled, make seat available again
        if ($request->payment === 'cancelled') {
            $order->seat->markAsAvailable();
        }

        return redirect()->route('orders.show', $id)
            ->with('success', 'Payment status updated successfully!');
    }

    // Cancel order
    public function cancel($id)
    {
        $order = Order::findOrFail($id);

        if ($order->payment === 'paid') {
            return redirect()->route('orders.show', $id)
                ->with('error', 'Cannot cancel a paid order');
        }

        $order->update(['payment' => 'cancelled']);
        $order->seat->markAsAvailable();

        return redirect()->route('orders.index')
            ->with('success', 'Order cancelled successfully!');
    }

    // Delete order
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Make seat available again
        $order->seat->markAsAvailable();

        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Order deleted successfully!');
    }
}
