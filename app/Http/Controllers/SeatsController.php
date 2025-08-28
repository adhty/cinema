<?php

namespace App\Http\Controllers;

use App\Models\Seats;
use App\Models\Ticket;
use Illuminate\Http\Request;

class SeatsController extends Controller
{
    public function index(Request $request)
    {
        $query = Seats::with(['ticket.movie', 'ticket.cinema', 'ticket.studio', 'order.user']);

        // Filter by ticket if provided
        if ($request->has('ticket_id') && $request->ticket_id) {
            $query->where('ticket_id', $request->ticket_id);
        }

        // Filter by status if provided
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $seats = $query->orderBy('ticket_id')->orderBy('number')->paginate(20);
        
        // Get all tickets for filter dropdown
        $tickets = Ticket::with(['movie', 'cinema', 'studio'])
            ->orderBy('date')
            ->orderBy('time')
            ->get();

        return view('seats.index', compact('seats', 'tickets'));
    }

    public function show($id)
    {
        $seat = Seats::with(['ticket.movie', 'ticket.cinema', 'ticket.studio', 'order.user'])
            ->findOrFail($id);

        return view('seats.show', compact('seat'));
    }

    public function byTicket($ticketId)
    {
        $ticket = Ticket::with(['movie', 'cinema', 'studio', 'city'])->findOrFail($ticketId);
        
        $seats = Seats::with(['order.user'])
            ->where('ticket_id', $ticketId)
            ->orderBy('number')
            ->get();

        // Group seats by status
        $availableSeats = $seats->where('status', 'available');
        $bookedSeats = $seats->where('status', 'booked');

        return view('seats.by-ticket', compact('ticket', 'seats', 'availableSeats', 'bookedSeats'));
    }
}
