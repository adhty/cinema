@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto mt-10 bg-white rounded-2xl shadow p-8">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between md:items-center mb-8">
        <h2 class="text-3xl font-bold text-purple-700 mb-4 md:mb-0">📦 Daftar Orders</h2>
        <span class="text-gray-500 text-sm">Terakhir diperbarui: {{ now()->format('d M Y H:i') }}</span>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-10">
        <div class="bg-purple-100 text-purple-700 p-4 rounded-xl shadow-sm text-center">
            <h3 class="text-2xl font-bold">{{ $stats['total'] }}</h3>
            <p class="text-sm font-semibold">Total Orders</p>
        </div>
        <div class="bg-yellow-100 text-yellow-700 p-4 rounded-xl shadow-sm text-center">
            <h3 class="text-2xl font-bold">{{ $stats['pending'] }}</h3>
            <p class="text-sm font-semibold">Pending</p>
        </div>
        <div class="bg-green-100 text-green-700 p-4 rounded-xl shadow-sm text-center">
            <h3 class="text-2xl font-bold">{{ $stats['paid'] }}</h3>
            <p class="text-sm font-semibold">Paid</p>
        </div>
        <div class="bg-red-100 text-red-700 p-4 rounded-xl shadow-sm text-center">
            <h3 class="text-2xl font-bold">{{ $stats['cancelled'] }}</h3>
            <p class="text-sm font-semibold">Cancelled</p>
        </div>
    </div>

    {{-- Search, Filter, Export --}}
    <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-col md:flex-row md:items-center md:space-x-4 mb-8">
        <div class="flex-1 mb-3 md:mb-0">
            <input type="text" name="search" placeholder="🔍 Cari user atau film..."
                value="{{ request('search') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500">
        </div>

        <div class="mb-3 md:mb-0">
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500">
                <option value="">Semua Status</option>
                <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <button type="submit"
            class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition duration-200">
            Filter
        </button>

        {{-- Tombol Export --}}
        <div class="flex space-x-3 mt-4 md:mt-0">
            <a href="{{ route('admin.orders.export.excel', request()->query()) }}"
                class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition">
                ⬇️ Export Excel
            </a>
            <a href="{{ route('admin.orders.export.pdf', request()->query()) }}"
                class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition">
                🧾 Export PDF
            </a>
        </div>
    </form>

    {{-- Tabel Orders --}}
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-purple-600 text-white">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Film</th>
                    <th class="px-4 py-3">Kursi</th>
                    <th class="px-4 py-3">Payment</th>
                    <th class="px-4 py-3">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($orders as $order)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-4 py-3 font-medium text-gray-700">#{{ $order->id }}</td>
                        <td class="px-4 py-3">{{ $order->user->name ?? '-' }}</td>
                        <td class="px-4 py-3 font-semibold text-purple-700">{{ $order->movie->title ?? '-' }}</td>
                        <td class="px-4 py-3">
                            @foreach($order->seats as $seat)
                                <span class="inline-block bg-gray-200 text-gray-800 text-xs font-semibold px-2 py-1 rounded mr-1">
                                    {{ $seat->number }}
                                </span>
                            @endforeach
                        </td>
                        <td class="px-4 py-3">
                            @if($order->payment === 'paid')
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Paid</span>
                            @elseif($order->payment === 'pending')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Pending</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Cancelled</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $order->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-6 text-gray-500">Tidak ada data order.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $orders->appends(request()->query())->links('pagination::tailwind') }}
    </div>
</div>
@endsection