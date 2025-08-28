<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Movie;
use App\Models\Studio;
use App\Models\City;
use App\Models\Cinema;
use App\Models\Seats;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with(['movie', 'studio', 'city', 'cinema'])
            ->orderBy('date')
            ->orderBy('time')
            ->paginate(20);

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $movies = Movie::all();
        $studios = Studio::all();
        $cities = City::all();
        $cinemas = Cinema::all();

        return view('tickets.create', compact('movies', 'studios', 'cities', 'cinemas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'studio_id' => 'required|exists:studios,id',
            'city_id' => 'required|exists:cities,id',
            'cinema_id' => 'required|exists:cinemas,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'price' => 'required|numeric|min:0',
        ]);

        $ticket = Ticket::create($request->only([
            'movie_id', 'studio_id', 'city_id', 'cinema_id', 'date', 'time', 'price'
        ]));

        // Auto-create seats if requested
        if ($request->has('create_seats')) {
            $this->createSeatsForTicket($ticket);
        }

        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully!');
    }


    public function show($id)
    {
        $ticket = Ticket::with(['movie', 'studio', 'city', 'cinema', 'seats.order.user'])->findOrFail($id);

        return view('tickets.show', compact('ticket'));
    }

    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $movies = Movie::all();
        $studios = Studio::all();
        $cities = City::all();
        $cinemas = Cinema::all();

        return view('tickets.edit', compact('ticket', 'movies', 'studios', 'cities', 'cinemas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'studio_id' => 'required|exists:studios,id',
            'city_id' => 'required|exists:cities,id',
            'cinema_id' => 'required|exists:cinemas,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'price' => 'required|numeric|min:0',
        ]);

        $ticket = Ticket::findOrFail($id);
        $ticket->update($request->only([
            'movie_id', 'studio_id', 'city_id', 'cinema_id', 'date', 'time', 'price'
        ]));

        return redirect()->route('tickets.show', $id)->with('success', 'Ticket updated successfully!');
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);

        // Check if ticket has any bookings
        $bookedSeats = $ticket->seats()->where('status', 'booked')->count();

        if ($bookedSeats > 0) {
            return redirect()->route('tickets.index')
                ->with('error', 'Cannot delete ticket with existing bookings!');
        }

        // Delete all seats first
        $ticket->seats()->delete();

        // Delete ticket
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully!');
    }

    private function createSeatsForTicket(Ticket $ticket)
    {
        $seatNumbers = ['A1', 'A2', 'A3', 'A4', 'A5', 'B1', 'B2', 'B3', 'B4', 'B5', 'C1', 'C2', 'C3', 'C4', 'C5'];

        foreach ($seatNumbers as $number) {
            Seats::create([
                'ticket_id' => $ticket->id,
                'number' => $number,
                'status' => 'available'
            ]);
        }
    }

}
