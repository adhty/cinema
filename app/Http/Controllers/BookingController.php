<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Seats;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Show available movies and showtimes
     */
    public function index()
    {
        $tickets = Ticket::with(['movie', 'cinema', 'studio', 'city', 'seats'])
            ->where('date', '>=', today())
            ->orderBy('date')
            ->orderBy('time')
            ->get()
            ->groupBy(function($ticket) {
                return $ticket->movie->title ?? 'Unknown Movie';
            });

        return view('booking.index', compact('tickets'));
    }

    /**
     * Show seat selection for a specific ticket
     */
    public function selectSeat($ticketId)
    {
        $ticket = Ticket::with(['movie', 'cinema', 'studio', 'city', 'seats.order.user'])
            ->findOrFail($ticketId);

        // Check if show is still available (not in the past)
        if ($ticket->date < today() || ($ticket->date == today() && $ticket->time < now()->format('H:i'))) {
            return redirect()->route('booking.index')
                ->with('error', 'This show has already passed!');
        }

        $seats = $ticket->seats->groupBy(function($seat) {
            return substr($seat->number, 0, 1); // Group by row (A, B, C)
        });

        return view('booking.select-seat', compact('ticket', 'seats'));
    }

    /**
     * Show customer form for selected seat
     */
    public function customerForm($seatId)
    {
        $seat = Seats::with(['ticket.movie', 'ticket.cinema', 'ticket.studio'])
            ->findOrFail($seatId);

        // Check if seat is still available
        if (!$seat->isAvailable()) {
            return redirect()->route('booking.select-seat', $seat->ticket_id)
                ->with('error', 'Sorry, this seat is no longer available!');
        }

        return view('booking.customer-form', compact('seat'));
    }

    /**
     * Process the booking
     */
    public function processBooking(Request $request, $seatId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'gender' => 'nullable|in:male,female',
            'birthdate' => 'nullable|date',
        ]);

        $seat = Seats::with(['ticket.movie', 'ticket.cinema', 'ticket.studio'])
            ->findOrFail($seatId);

        // Double check seat availability
        if (!$seat->isAvailable()) {
            return redirect()->route('booking.select-seat', $seat->ticket_id)
                ->with('error', 'Sorry, this seat is no longer available!');
        }

        try {
            DB::beginTransaction();

            // Create or find user
            $user = User::firstOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'gender' => $request->gender,
                    'birthdate' => $request->birthdate,
                    'password' => bcrypt('password123'), // Default password
                    'is_admin' => false,
                ]
            );

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'seat_id' => $seat->id,
                'payment' => 'pending'
            ]);

            // Mark seat as booked
            $seat->markAsBooked();

            DB::commit();

            return redirect()->route('booking.confirmation', $order->id)
                ->with('success', 'Booking successful! Please proceed with payment.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('booking.select-seat', $seat->ticket_id)
                ->with('error', 'Booking failed. Please try again.');
        }
    }

    /**
     * Show booking confirmation and payment info
     */
    public function confirmation($orderId)
    {
        $order = Order::with(['user', 'seat.ticket.movie', 'seat.ticket.cinema', 'seat.ticket.studio'])
            ->findOrFail($orderId);

        return view('booking.confirmation', compact('order'));
    }

    /**
     * Simulate payment (for demo purposes)
     */
    public function simulatePayment($orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->payment !== 'pending') {
            return redirect()->route('booking.confirmation', $orderId)
                ->with('error', 'This order has already been processed!');
        }

        $order->update(['payment' => 'paid']);

        return redirect()->route('booking.ticket', $orderId)
            ->with('success', 'Payment successful! Here is your ticket.');
    }

    /**
     * Show digital ticket
     */
    public function ticket($orderId)
    {
        $order = Order::with(['user', 'seat.ticket.movie', 'seat.ticket.cinema', 'seat.ticket.studio'])
            ->findOrFail($orderId);

        if ($order->payment !== 'paid') {
            return redirect()->route('booking.confirmation', $orderId)
                ->with('error', 'Payment required to view ticket!');
        }

        return view('booking.ticket', compact('order'));
    }

    /**
     * Cancel booking (only for pending orders)
     */
    public function cancel($orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->payment !== 'pending') {
            return redirect()->route('booking.confirmation', $orderId)
                ->with('error', 'Cannot cancel a paid order!');
        }

        try {
            DB::beginTransaction();

            // Mark seat as available
            $order->seat->markAsAvailable();
            
            // Update order status
            $order->update(['payment' => 'cancelled']);

            DB::commit();

            return redirect()->route('booking.index')
                ->with('success', 'Booking cancelled successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('booking.confirmation', $orderId)
                ->with('error', 'Failed to cancel booking. Please try again.');
        }
    }
}
