<?php

namespace App\Http\Controllers;

use App\Models\Seats;
use App\Models\Ticket;
use Illuminate\Http\Request;

class SeatsController extends Controller
{
    public function index(Request $request)
    {
        $query = Seats::with([
            'ticket.movie',
            'ticket.cinema',
            'ticket.studio',
            'order.user'
        ]);

        // Filter berdasarkan ticket
        if ($request->filled('ticket_id')) {
            $query->where('ticket_id', $request->ticket_id);
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

        return view('admin.seats.index', compact('seats', 'tickets'));
    }

    public function create()
    {
        $tickets = Ticket::all(); // biar bisa pilih tiket mana kursinya
        return view('admin.seats.create', compact('tickets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'number' => 'required|string|max:10',
            'status' => 'required|in:available,booked'
        ]);

        Seats::create($request->all());

        return redirect()->route('admin.seats.index')
            ->with('success', 'Kursi berhasil ditambahkan!');
    }

    public function show($id)
    {
        $seat = Seats::with([
            'ticket.movie',
            'ticket.cinema',
            'ticket.studio',
            'order.user'
        ])->findOrFail($id);

        return view('admin.seats.show', compact('seat'));
    }

    public function byTicket($ticketId)
    {
        $ticket = Ticket::with(['movie', 'cinema', 'studio', 'city'])
            ->findOrFail($ticketId);

        // Ambil semua kursi untuk tiket ini
        $seats = Seats::with(['order.user'])
            ->where('ticket_id', $ticketId)
            ->orderBy('number')
            ->get();

        // Pisahkan kursi berdasarkan status
        $availableSeats = $seats->where('status', 'available');
        $bookedSeats = $seats->where('status', 'booked');

        return view('seats.by-ticket', compact(
            'ticket',
            'seats',
            'availableSeats',
            'bookedSeats'
        ));
    }
}
