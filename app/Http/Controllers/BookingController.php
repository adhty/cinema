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
    // Tampilkan halaman index (Blade)
    public function index()
    {
        return view('booking.index'); // hanya return view kosong
    }

    // API JSON untuk ambil tiket
    public function getTickets()
    {
        $tickets = Ticket::with(['movie', 'cinema', 'studio', 'city', 'seats'])
            ->where('date', '>=', today())
            ->orderBy('date')
            ->orderBy('time')
            ->get()
            ->groupBy(fn($ticket) => $ticket->movie->title ?? 'Unknown Movie');

        return response()->json($tickets);
    }

    // Pilih kursi
    public function selectSeat($ticketId)
    {
        $ticket = Ticket::with(['movie', 'cinema', 'studio', 'city', 'seats.order.user'])
            ->findOrFail($ticketId);

        if ($ticket->date < today() || ($ticket->date == today() && $ticket->time < now()->format('H:i'))) {
            return redirect()->route('booking.index')
                ->with('error', 'This show has already passed!');
        }

        $seats = $ticket->seats->groupBy(fn($seat) => substr($seat->number, 0, 1));

        return view('booking.select-seat', compact('ticket', 'seats'));
    }

    // Proses booking kursi
    public function processBooking(Request $request, $seatId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $seat = Seats::with(['ticket'])->findOrFail($seatId);

        if (!$seat->isAvailable()) {
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => 'Seat not available'])
                : redirect()->route('booking.select-seat', $seat->ticket_id)
                    ->with('error', 'Sorry, this seat is no longer available!');
        }

        try {
            DB::beginTransaction();

            $user = User::firstOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'password' => bcrypt('password123'),
                    'is_admin' => false,
                ]
            );

            $order = Order::create([
                'user_id' => $user->id,
                'seat_id' => $seat->id,
                'payment' => 'pending'
            ]);

            $seat->markAsBooked();

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'order_id' => $order->id
                ]);
            }

            return redirect()->route('booking.confirmation', $order->id)
                ->with('success', 'Booking successful! Please proceed with payment.');

        } catch (\Exception $e) {
            DB::rollBack();

            return $request->ajax()
                ? response()->json(['success' => false, 'message' => 'Booking failed.'])
                : redirect()->route('booking.select-seat', $seat->ticket_id)
                    ->with('error', 'Booking failed. Please try again.');
        }
    }

    // Konfirmasi booking
    public function confirmation($orderId)
    {
        $order = Order::with(['user', 'seat.ticket.movie', 'seat.ticket.cinema', 'seat.ticket.studio'])
            ->findOrFail($orderId);

        return view('booking.confirmation', compact('order'));
    }

    // Simulasi pembayaran
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

    // Tampilkan tiket
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

    // Batalkan booking
    public function cancel($orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->payment !== 'pending') {
            return redirect()->route('booking.confirmation', $orderId)
                ->with('error', 'Cannot cancel a paid order!');
        }

        try {
            DB::beginTransaction();

            $order->seat->markAsAvailable();
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
