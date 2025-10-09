@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-6">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">🎫 Tickets Management</h1>
        <a href="{{ route('admin.tickets.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            + Add New Ticket
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-600 text-white p-4 rounded shadow">
            <h5 class="font-semibold">Total Tickets</h5>
            <p class="text-2xl font-bold">{{ $tickets->total() }}</p>
        </div>
        <div class="bg-cyan-500 text-white p-4 rounded shadow">
            <h5 class="font-semibold">Today's Shows</h5>
            <p class="text-2xl font-bold">{{ $tickets->where('date', today()->format('Y-m-d'))->count() }}</p>
        </div>
        <div class="bg-green-500 text-white p-4 rounded shadow">
            <h5 class="font-semibold">This Week</h5>
            <p class="text-2xl font-bold">{{ $tickets->whereBetween('date', [today(), today()->addWeek()])->count() }}</p>
        </div>
        <div class="bg-yellow-500 text-white p-4 rounded shadow">
            <h5 class="font-semibold">Upcoming</h5>
            <p class="text-2xl font-bold">{{ $tickets->where('date', '>', today()->format('Y-m-d'))->count() }}</p>
        </div>
    </div>

    {{-- Tickets Table --}}
    <div class="bg-white shadow rounded overflow-x-auto">
        @if($tickets->count() > 0)
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Movie</th>
                    <th class="px-4 py-2 text-left">Cinema</th>
                    <th class="px-4 py-2 text-left">Studio</th>
                    <th class="px-4 py-2 text-left">City</th>
                    <th class="px-4 py-2 text-left">Date</th>
                    <th class="px-4 py-2 text-left">Time</th>
                    <th class="px-4 py-2 text-left">Price</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($tickets as $ticket)
                <tr>
                    <td class="px-4 py-2 font-semibold">{{ $ticket->id }}</td>
                    <td class="px-4 py-2">{{ $ticket->movie->title ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $ticket->cinema->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $ticket->studio->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $ticket->city->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 rounded {{ $ticket->date >= today() ? 'bg-green-500 text-white' : 'bg-gray-400 text-white' }}">
                            {{ $ticket->date ?? 'N/A' }}
                        </span>
                    </td>
                    <td class="px-4 py-2">{{ $ticket->time ?? 'N/A' }}</td>
                    <td class="px-4 py-2 font-bold">Rp {{ number_format($ticket->price ?? 0, 0, ',', '.') }}</td>
                    <td class="px-4 py-2 flex gap-1">
                        <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition text-sm">View</a>
                        <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="bg-yellow-400 text-white px-2 py-1 rounded hover:bg-yellow-500 transition text-sm">Edit</a>
                        <form method="POST" action="{{ route('admin.tickets.destroy', $ticket->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition text-sm">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-4 px-4">
            {{ $tickets->links() }}
        </div>

        @else
        <div class="text-center p-6 text-gray-500">
            <p>No tickets found.</p>
            <a href="{{ route('admin.tickets.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition mt-2 inline-block">
                Create First Ticket
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
