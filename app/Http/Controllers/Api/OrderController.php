<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Seats;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of orders for a specific user
     */
    public function index(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $orders = Order::with(['seat.ticket.movie', 'seat.ticket.cinema', 'seat.ticket.studio'])
            ->where('user_id', $request->user_id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'seat_number' => $order->seat->number,
                    'movie_title' => $order->seat->ticket->movie->title ?? 'N/A',
                    'cinema_name' => $order->seat->ticket->cinema->name ?? 'N/A',
                    'studio_name' => $order->seat->ticket->studio->name ?? 'N/A',
                    'show_date' => $order->seat->ticket->date ?? 'N/A',
                    'show_time' => $order->seat->ticket->time ?? 'N/A',
                    'price' => $order->seat->ticket->price ?? 0,
                    'payment_status' => $order->payment,
                    'created_at' => $order->created_at->format('Y-m-d H:i:s'),
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Orders retrieved successfully',
            'data' => $orders
        ], 200);
    }

    /**
     * Store a newly created order
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'seat_id' => 'required|exists:seats,id',
        ]);

        try {
            DB::beginTransaction();

            // Check if seat is available
            $seat = Seats::find($request->seat_id);
            
            if (!$seat->isAvailable()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Seat is not available for booking'
                ], 400);
            }

            // Check if user already has an order for this seat
            $existingOrder = Order::where('user_id', $request->user_id)
                ->where('seat_id', $request->seat_id)
                ->first();

            if ($existingOrder) {
                return response()->json([
                    'success' => false,
                    'message' => 'User already has an order for this seat'
                ], 400);
            }

            // Create the order
            $order = Order::create([
                'user_id' => $request->user_id,
                'seat_id' => $request->seat_id,
                'payment' => 'pending'
            ]);

            // Mark seat as booked
            $seat->markAsBooked();

            DB::commit();

            // Load relationships for response
            $order->load(['seat.ticket.movie', 'seat.ticket.cinema', 'seat.ticket.studio', 'user']);

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => [
                    'order_id' => $order->id,
                    'user_name' => $order->user->name,
                    'seat_number' => $order->seat->number,
                    'movie_title' => $order->seat->ticket->movie->title ?? 'N/A',
                    'cinema_name' => $order->seat->ticket->cinema->name ?? 'N/A',
                    'studio_name' => $order->seat->ticket->studio->name ?? 'N/A',
                    'show_date' => $order->seat->ticket->date ?? 'N/A',
                    'show_time' => $order->seat->ticket->time ?? 'N/A',
                    'price' => $order->seat->ticket->price ?? 0,
                    'payment_status' => $order->payment,
                    'created_at' => $order->created_at->format('Y-m-d H:i:s'),
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified order
     */
    public function show($id)
    {
        $order = Order::with(['seat.ticket.movie', 'seat.ticket.cinema', 'seat.ticket.studio', 'user'])
            ->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order retrieved successfully',
            'data' => [
                'order_id' => $order->id,
                'user_name' => $order->user->name,
                'user_email' => $order->user->email,
                'user_phone' => $order->user->phone,
                'seat_number' => $order->seat->number,
                'movie_title' => $order->seat->ticket->movie->title ?? 'N/A',
                'cinema_name' => $order->seat->ticket->cinema->name ?? 'N/A',
                'studio_name' => $order->seat->ticket->studio->name ?? 'N/A',
                'show_date' => $order->seat->ticket->date ?? 'N/A',
                'show_time' => $order->seat->ticket->time ?? 'N/A',
                'price' => $order->seat->ticket->price ?? 0,
                'payment_status' => $order->payment,
                'created_at' => $order->created_at->format('Y-m-d H:i:s'),
            ]
        ], 200);
    }

    /**
     * Update payment status of an order
     */
    public function updatePayment(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,cancelled'
        ]);

        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        try {
            DB::beginTransaction();

            $order->update(['payment' => $request->payment_status]);

            // If order is cancelled, make seat available again
            if ($request->payment_status === 'cancelled') {
                $order->seat->markAsAvailable();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment status updated successfully',
                'data' => [
                    'order_id' => $order->id,
                    'payment_status' => $order->payment
                ]
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update payment status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancel an order
     */
    public function cancel($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        if ($order->payment === 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot cancel a paid order'
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Mark order as cancelled
            $order->update(['payment' => 'cancelled']);
            
            // Make seat available again
            $order->seat->markAsAvailable();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel order: ' . $e->getMessage()
            ], 500);
        }
    }
}
