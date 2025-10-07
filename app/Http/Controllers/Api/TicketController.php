<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function index()
    {
        return response()->json(Ticket::with(['movie', 'studio', 'cinema', 'city'])->get());
    }

    public function show($id)
    {
        $ticket = Ticket::with(['movie', 'studio', 'cinema', 'city', 'seats'])->findOrFail($id);
        return response()->json($ticket);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'studio_id' => 'required|exists:studios,id',
            'city_id' => 'required|exists:cities,id',
            'cinema_id' => 'required|exists:cinemas,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'price' => 'required|numeric|min:0',
        ]);

        $ticket = Ticket::create($validated);

        // Bisa tambahkan auto-generate kursi kalau kamu mau
        // Contoh:
        // if ($request->has('create_seats')) {
        //     $this->createSeatsForTicket($ticket);
        // }

        return response()->json([
            'message' => 'Ticket created successfully!',
            'data' => $ticket
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $validated = $request->validate([
            'movie_id' => 'exists:movies,id',
            'studio_id' => 'exists:studios,id',
            'city_id' => 'exists:cities,id',
            'cinema_id' => 'exists:cinemas,id',
            'date' => 'date|after_or_equal:today',
            'time' => 'string',
            'price' => 'numeric|min:0',
        ]);

        $ticket->update($validated);

        return response()->json([
            'message' => 'Ticket updated successfully!',
            'data' => $ticket
        ]);
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return response()->json(['message' => 'Ticket deleted successfully!']);
    }
}
