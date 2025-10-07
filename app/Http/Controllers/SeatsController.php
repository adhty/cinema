<?php

namespace App\Http\Controllers;

use App\Models\Seats;
use App\Models\Ticket;
use Illuminate\Http\Request;

class SeatsController extends Controller
{
    // List semua seats dengan filter dan pagination
    public function index(Request $request)
    {
        $query = Seats::with([
            'ticket.movie',
            'ticket.cinema',
            'ticket.studio',
            'order.user' // perbaiki dari 'orders.user' karena relasi di model singular
        ]);

        // Filter berdasarkan ticket
        $ticketId = $request->ticket_id ?? null; // ambil dari request
        if ($ticketId) {
            $query->where('ticket_id', $ticketId);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $seats = $query->orderBy('ticket_id')
            ->orderBy('number')
            ->paginate(20);

        // Dropdown filter ticket
        $tickets = Ticket::with(['movie', 'cinema', 'studio'])
            ->orderBy('date')
            ->orderBy('time')
            ->get();

        // Kirim ticketId ke view supaya Blade tidak error
        return view('admin.seats.index', compact('seats', 'tickets', 'ticketId'));
    }


    // Form create seat
    public function create()
    {
        $tickets = Ticket::all();
        return view('admin.seats.create', compact('tickets'));
    }

    // Store seat baru
    public function store(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'number'    => 'required|string|max:10',
            'status'    => 'required|in:available,booked'
        ]);

        Seats::create($request->all());

        return redirect()->route('admin.seats.index')
            ->with('success', 'Kursi berhasil ditambahkan!');
    }

    // Show detail seat + relasi
    public function show(Seats $seat)
    {
        $seat->load([
            'ticket.movie',
            'ticket.cinema',
            'ticket.studio',
            'orders.user'
        ]);

        return view('admin.seats.show', compact('seat'));
    }

    // Menampilkan seats berdasarkan ticket
    public function byTicket($ticketId)
    {
        $ticket = Ticket::with(['movie', 'cinema', 'studio', 'city'])->findOrFail($ticketId);

        $seats = Seats::with(['orders.user'])
            ->where('ticket_id', $ticketId)
            ->orderBy('number')
            ->get();

        $availableSeats = $seats->where('status', 'available');
        $bookedSeats    = $seats->where('status', 'booked');

        return view('seats.by-ticket', compact(
            'ticket',
            'seats',
            'availableSeats',
            'bookedSeats'
        ));
    }
}
