<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Seat;
use App\Models\Seats;
use App\Models\Ticket;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function index(Request $request)
    {
        $query = Seats::with(['ticket.movie', 'ticket.cinema', 'ticket.studio', 'order.user']);

        if ($request->filled('ticket_id')) {
            $query->where('ticket_id', $request->ticket_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $seats = $query->orderBy('number')->get();

        return response()->json([
            'success' => true,
            'data'    => $seats
        ]);
    }
    public function available(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id'
        ]);

        $ticket = Ticket::with(['movie', 'cinema', 'studio', 'city'])->findOrFail($request->ticket_id);

        $seats = Seats::where('ticket_id', $ticket->id)
            ->with('order')
            ->get()
            ->map(fn($seat) => [
                'id'          => $seat->id,
                'number'      => $seat->number,
                'status'      => $seat->status,
                'is_available' => $seat->isAvailable(),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Available seats retrieved successfully',
            'data'    => [
                'ticket' => [
                    'id'     => $ticket->id,
                    'movie'  => $ticket->movie->title ?? 'N/A',
                    'cinema' => $ticket->cinema->name ?? 'N/A',
                    'studio' => $ticket->studio->name ?? 'N/A',
                    'city'   => $ticket->city->name ?? 'N/A',
                    'date'   => $ticket->date,
                    'time'   => $ticket->time,
                    'price'  => $ticket->price,
                ],
                'seats' => $seats->where('is_available', true)->values(),
            ]
        ]);
    }

    /**
     * GET /api/seats/ticket/{ticketId}
     * Ambil semua kursi berdasarkan ticket ID
     */
    public function byTicket($ticketId)
    {
        $ticket = Ticket::with(['movie', 'cinema', 'studio', 'city'])->findOrFail($ticketId);

        $seats = Seats::where('ticket_id', $ticketId)
            ->with(['order.user'])
            ->orderBy('number')
            ->get()
            ->map(function ($seat) {
                $data = [
                    'id'          => $seat->id,
                    'number'      => $seat->number,
                    'status'      => $seat->status,
                    'is_available' => $seat->isAvailable(),
                ];

                if ($seat->order) {
                    $data['order'] = [
                        'id'       => $seat->order->id,
                        'user'     => $seat->order->user->name ?? 'N/A',
                        'payment'  => $seat->order->payment,
                        'booked_at' => $seat->order->created_at->toDateTimeString(),
                    ];
                }

                return $data;
            });

        return response()->json([
            'success' => true,
            'message' => 'All seats retrieved successfully',
            'data'    => [
                'ticket' => [
                    'id'     => $ticket->id,
                    'movie'  => $ticket->movie->title ?? 'N/A',
                    'cinema' => $ticket->cinema->name ?? 'N/A',
                    'studio' => $ticket->studio->name ?? 'N/A',
                    'city'   => $ticket->city->name ?? 'N/A',
                    'date'   => $ticket->date,
                    'time'   => $ticket->time,
                    'price'  => $ticket->price,
                ],
                'seats' => $seats
            ]
        ]);
    }

    /**
     * GET /api/seats/{id}
     * Ambil detail kursi berdasarkan ID
     */
    public function show($id)
    {
        $seat = Seats::with(['ticket.movie', 'ticket.cinema', 'ticket.studio', 'ticket.city', 'order.user'])
            ->findOrFail($id);

        $data = [
            'id'          => $seat->id,
            'number'      => $seat->number,
            'status'      => $seat->status,
            'is_available' => $seat->isAvailable(),
            'ticket'      => [
                'id'     => $seat->ticket->id,
                'movie'  => $seat->ticket->movie->title ?? 'N/A',
                'cinema' => $seat->ticket->cinema->name ?? 'N/A',
                'studio' => $seat->ticket->studio->name ?? 'N/A',
                'city'   => $seat->ticket->city->name ?? 'N/A',
                'date'   => $seat->ticket->date,
                'time'   => $seat->ticket->time,
                'price'  => $seat->ticket->price,
            ]
        ];

        if ($seat->order) {
            $data['order'] = [
                'id'      => $seat->order->id,
                'user'    => [
                    'name'  => $seat->order->user->name ?? 'N/A',
                    'email' => $seat->order->user->email ?? 'N/A',
                    'phone' => $seat->order->user->phone ?? 'N/A',
                ],
                'payment' => $seat->order->payment,
                'booked_at' => $seat->order->created_at->toDateTimeString(),
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Seat details retrieved successfully',
            'data'    => $data
        ]);
    }
}
