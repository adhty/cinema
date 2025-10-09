@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Promos</h1>
        <a href="{{ route('admin.promos.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            Add New Promo
        </a>
    </div>

    {{-- Navigation Tabs --}}
    <div class="mb-4 border-b border-gray-200">
        <nav class="flex -mb-px space-x-4">
            <a href="{{ route('admin.promos.index', ['status' => 'all']) }}"
               class="px-3 py-2 font-medium text-gray-700 border-b-2 {{ $status == 'all' || is_null($status) ? 'border-blue-600 text-blue-600' : 'border-transparent hover:text-gray-900 hover:border-gray-300' }}">
               All Promos
            </a>
            <a href="{{ route('admin.promos.index', ['status' => 'active']) }}"
               class="px-3 py-2 font-medium text-gray-700 border-b-2 {{ $status == 'active' ? 'border-blue-600 text-blue-600' : 'border-transparent hover:text-gray-900 hover:border-gray-300' }}">
               Active Promos
            </a>
            <a href="{{ route('admin.promos.index', ['status' => 'expired']) }}"
               class="px-3 py-2 font-medium text-gray-700 border-b-2 {{ $status == 'expired' ? 'border-blue-600 text-blue-600' : 'border-transparent hover:text-gray-900 hover:border-gray-300' }}">
               Expired Promos
            </a>
        </nav>
    </div>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Promo Table --}}
    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Cover</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Title</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Deadline</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Status</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($promos as $promo)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2">
                        @if ($promo->cover)
                            <img src="{{ asset('storage/' . $promo->cover) }}" alt="{{ $promo->title }}" class="w-24 h-16 object-cover rounded">
                        @else
                            <span class="text-gray-400 text-sm">No Image</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 text-gray-800">{{ $promo->title }}</td>
                    <td class="px-4 py-2 text-gray-600">{{ $promo->deadline->format('d M Y') }}</td>
                    <td class="px-4 py-2">
                        @if ($promo->deadline >= now())
                            <span class="inline-flex items-center px-2 py-1 rounded bg-green-100 text-green-800 text-sm font-semibold">Active</span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded bg-red-100 text-red-800 text-sm font-semibold">Expired</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="{{ route('admin.promos.show', $promo) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">View</a>
                        <a href="{{ route('admin.promos.edit', $promo) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm">Edit</a>
                        <form action="{{ route('admin.promos.destroy', $promo) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if($promos->isEmpty())
                <tr>
                    <td colspan="5" class="px-4 py-4 text-center text-gray-500">No promos found.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
