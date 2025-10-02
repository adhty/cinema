@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Daftar Orders</h2>

    {{-- Statistik --}}
    <div class="mb-3">
        <p>Total Orders: {{ $stats['total'] }}</p>
        <p>Pending: {{ $stats['pending'] }}</p>
        <p>Paid: {{ $stats['paid'] }}</p>
        <p>Cancelled: {{ $stats['cancelled'] }}</p>
    </div>

    {{-- Tabel Orders --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Film</th>
                <th>Kursi</th>
                <th>Payment</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name ?? '-' }}</td>
                    <td>{{ $order->movie->title ?? '-' }}</td>
                    <td>
                        @foreach($order->seats as $seat)
                            {{ $seat->number }}{{ !$loop->last ? ',' : '' }}
                        @endforeach
                    </td>
                    <td>{{ ucfirst($order->payment) }}</td>
                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pagination --}}
    {{ $orders->links() }}
</div>
@endsection
