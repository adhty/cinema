<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Seats;
use App\Models\Ticket;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    /**
     * Get available seats for a specific ticket/schedule
     */
    public function getAvailableSeats(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id'
        ]);

        try {
            // Get ticket information
            $ticket = Ticket::with(['movie', 'cinema', 'studio', 'city'])->find($request->ticket_id);

            if (!$ticket) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ticket not found'
                ], 404);
            }

            // Get all seats for this ticket
            $seats = Seats::where('ticket_id', $request->ticket_id)
                ->with('order')
                ->get()
                ->map(function ($seat) {
                    return [
                        'seat_id' => $seat->id,
                        'seat_number' => $seat->number,
                        'status' => $seat->status,
                        'is_available' => $seat->isAvailable(),
                        'is_booked' => !$seat->isAvailable()
                    ];
                });

            // Separate available and booked seats
            $availableSeats = $seats->where('is_available', true)->values();
            $bookedSeats = $seats->where('is_available', false)->values();

            return response()->json([
                'success' => true,
                'message' => 'Seats retrieved successfully',
                'data' => [
                    'ticket_info' => [
                        'ticket_id' => $ticket->id,
                        'movie_title' => $ticket->movie->title ?? 'N/A',
                        'cinema_name' => $ticket->cinema->name ?? 'N/A',
                        'studio_name' => $ticket->studio->name ?? 'N/A',
                        'city_name' => $ticket->city->name ?? 'N/A',
                        'show_date' => $ticket->date,
                        'show_time' => $ticket->time,
                        'price' => $ticket->price
                    ],
                    'seats' => [
                        'available' => $availableSeats,
                        'booked' => $bookedSeats,
                        'total_seats' => $seats->count(),
                        'available_count' => $availableSeats->count(),
                        'booked_count' => $bookedSeats->count()
                    ]
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve seats: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all seats for a specific ticket (both available and booked)
     */
    public function getAllSeats($ticketId)
    {
        try {
            // Get ticket information
            $ticket = Ticket::with(['movie', 'cinema', 'studio', 'city'])->find($ticketId);

            if (!$ticket) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ticket not found'
                ], 404);
            }

            // Get all seats for this ticket
            $seats = Seats::where('ticket_id', $ticketId)
                ->with(['order.user'])
                ->orderBy('number')
                ->get()
                ->map(function ($seat) {
                    $seatData = [
                        'seat_id' => $seat->id,
                        'seat_number' => $seat->number,
                        'status' => $seat->status,
                        'is_available' => $seat->isAvailable(),
                    ];

                    // Add order information if seat is booked
                    if ($seat->order) {
                        $seatData['order_info'] = [
                            'order_id' => $seat->order->id,
                            'user_name' => $seat->order->user->name ?? 'N/A',
                            'payment_status' => $seat->order->payment,
                            'booked_at' => $seat->order->created_at->format('Y-m-d H:i:s')
                        ];
                    }

                    return $seatData;
                });

            return response()->json([
                'success' => true,
                'message' => 'All seats retrieved successfully',
                'data' => [
                    'ticket_info' => [
                        'ticket_id' => $ticket->id,
                        'movie_title' => $ticket->movie->title ?? 'N/A',
                        'cinema_name' => $ticket->cinema->name ?? 'N/A',
                        'studio_name' => $ticket->studio->name ?? 'N/A',
                        'city_name' => $ticket->city->name ?? 'N/A',
                        'show_date' => $ticket->date,
                        'show_time' => $ticket->time,
                        'price' => $ticket->price
                    ],
                    'seats' => $seats
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve seats: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get seat details by seat ID
     */
    public function show($seatId)
    {
        try {
            $seat = Seats::with(['ticket.movie', 'ticket.cinema', 'ticket.studio', 'ticket.city', 'order.user'])
                ->find($seatId);

            if (!$seat) {
                return response()->json([
                    'success' => false,
                    'message' => 'Seat not found'
                ], 404);
            }

            $seatData = [
                'seat_id' => $seat->id,
                'seat_number' => $seat->number,
                'status' => $seat->status,
                'is_available' => $seat->isAvailable(),
                'ticket_info' => [
                    'ticket_id' => $seat->ticket->id,
                    'movie_title' => $seat->ticket->movie->title ?? 'N/A',
                    'cinema_name' => $seat->ticket->cinema->name ?? 'N/A',
                    'studio_name' => $seat->ticket->studio->name ?? 'N/A',
                    'city_name' => $seat->ticket->city->name ?? 'N/A',
                    'show_date' => $seat->ticket->date,
                    'show_time' => $seat->ticket->time,
                    'price' => $seat->ticket->price
                ]
            ];

            // Add order information if seat is booked
            if ($seat->order) {
                $seatData['order_info'] = [
                    'order_id' => $seat->order->id,
                    'user_name' => $seat->order->user->name ?? 'N/A',
                    'user_email' => $seat->order->user->email ?? 'N/A',
                    'user_phone' => $seat->order->user->phone ?? 'N/A',
                    'payment_status' => $seat->order->payment,
                    'booked_at' => $seat->order->created_at->format('Y-m-d H:i:s')
                ];
            }

            return response()->json([
                'success' => true,
                'message' => 'Seat details retrieved successfully',
                'data' => $seatData
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve seat details: ' . $e->getMessage()
            ], 500);
        }
    }
}
