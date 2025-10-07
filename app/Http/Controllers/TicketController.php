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
    // List semua tiket
    public function index()
    {
        $tickets = Ticket::with(['movie', 'studio', 'city', 'cinema'])
            ->orderBy('date')
            ->orderBy('time')
            ->paginate(20);

        return view('admin.tickets.index', compact('tickets'));
    }

    // Form buat tiket baru
    public function create()
    {
        $movies = Movie::all();
        $studios = Studio::all();
        $cities = City::all();
        $cinemas = Cinema::all();

        return view('admin.tickets.create', compact('movies', 'studios', 'cities', 'cinemas'));
    }

    // Simpan tiket baru
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
            'movie_id',
            'studio_id',
            'city_id',
            'cinema_id',
            'date',
            'time',
            'price'
        ]));

        if ($request->has('create_seats')) {
            $this->createSeatsForTicket($ticket);
        }

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Ticket created successfully!');
    }

    // Tampilkan detail tiket
    public function show($id)
    {
        $ticket = Ticket::with(['movie', 'studio', 'city', 'cinema', 'seats.order.user'])->findOrFail($id);

        return view('admin.tickets.show', compact('ticket'));
    }

    // Form edit tiket
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $movies = Movie::all();
        $studios = Studio::all();
        $cities = City::all();
        $cinemas = Cinema::all();

        return view('admin.tickets.edit', compact('ticket', 'movies', 'studios', 'cities', 'cinemas'));
    }

    // Update tiket
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
            'movie_id',
            'studio_id',
            'city_id',
            'cinema_id',
            'date',
            'time',
            'price'
        ]));

        return redirect()->route('admin.tickets.show', $id)
            ->with('success', 'Ticket updated successfully!');
    }

    // Hapus tiket
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);

        $bookedSeats = $ticket->seats()->where('status', 'booked')->count();

        if ($bookedSeats > 0) {
            return redirect()->route('admin.tickets.index')
                ->with('error', 'Cannot delete ticket with existing bookings!');
        }

        $ticket->seats()->delete();
        $ticket->delete();

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Ticket deleted successfully!');
    }

    // Buat seats otomatis
    private function createSeatsForTicket(Ticket $ticket)
    {
        $seatNumbers = [
            'A1',
            'A2',
            'A3',
            'A4',
            'A5',
            'B1',
            'B2',
            'B3',
            'B4',
            'B5',
            'C1',
            'C2',
            'C3',
            'C4',
            'C5'
        ];

        // Ambil seat yang sudah ada
        $existingSeats = Seats::where('ticket_id', $ticket->id)
            ->pluck('number')
            ->toArray();

        // Filter seat yang belum ada
        $newSeats = array_diff($seatNumbers, $existingSeats);

        // Siapkan data untuk insert massal
        $insertData = array_map(function ($number) use ($ticket) {
            return [
                'ticket_id' => $ticket->id,
                'number' => $number,
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now()
            ];
        }, $newSeats);

        if (!empty($insertData)) {
            Seats::insert($insertData); // Mass insert
        }
    }


    // AJAX: jadwal tiket per cinema & tanggal
    public function getScheduleAjax($cinemaId, $date)
    {
        $schedules = Ticket::with(['movie', 'studio', 'cinema'])
            ->where('cinema_id', $cinemaId)
            ->where('date', $date)
            ->orderBy('movie_id')
            ->orderBy('time')
            ->get()
            ->groupBy('movie_id');

        return response()->json($schedules);
    }
}
