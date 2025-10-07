<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Seats;
use App\Models\Ticket;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    /**
     * GET /api/seats
     * List semua seats dengan filter optional
     */
    public function index(Request $request)
    {
        $query = Seats::with([
            'ticket.movie',
            'ticket.cinema',
            'ticket.studio',
            'orders.user'
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

        return response()->json($seats);
    }

    /**
     * POST /api/seats
     * Tambah kursi baru (admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'number'    => 'required|string|max:10',
            'status'    => 'required|in:available,booked'
        ]);

        $seat = Seats::create([
            'ticket_id' => $request->ticket_id,
            'number'    => $request->number,
            'status'    => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Seat created successfully',
            'data'    => $seat
        ], 201);
    }

    /**
     * GET /api/seats/{id}
     * Detail seat beserta ticket dan orders
     */
    public function show($id)
    {
        $seat = Seats::with([
            'ticket.movie',
            'ticket.cinema',
            'ticket.studio',
            'orders.user'
        ])->findOrFail($id);

        return response()->json($seat);
    }

    /**
     * GET /api/seats/ticket/{ticketId}
     * Ambil semua seats berdasarkan ticket
     */
    public function byTicket($ticketId)
    {
        $ticket = Ticket::with(['movie', 'cinema', 'studio', 'city'])->findOrFail($ticketId);

        $seats = Seats::with(['orders.user'])
            ->where('ticket_id', $ticketId)
            ->orderBy('number')
            ->get();

        $availableSeats = $seats->where('status', 'available')->values();
        $bookedSeats = $seats->where('status', 'booked')->values();

        return response()->json([
            'ticket'         => $ticket,
            'seats'          => $seats,
            'availableSeats' => $availableSeats,
            'bookedSeats'    => $bookedSeats,
        ]);
    }

    /**
     * PUT /api/seats/{id}
     * Update seat (admin)
     */
    public function update(Request $request, $id)
    {
        $seat = Seats::findOrFail($id);

        $request->validate([
            'number' => 'sometimes|string|max:10',
            'status' => 'sometimes|in:available,booked'
        ]);

        $seat->update($request->only(['number', 'status']));

        return response()->json([
            'success' => true,
            'message' => 'Seat updated successfully',
            'data'    => $seat
        ]);
    }

    /**
     * DELETE /api/seats/{id}
     * Hapus seat (admin)
     */
    public function destroy($id)
    {
        $seat = Seats::findOrFail($id);
        $seat->delete();

        return response()->json([
            'success' => true,
            'message' => 'Seat deleted successfully'
        ]);
    }
}
