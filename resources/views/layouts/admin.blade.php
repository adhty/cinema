<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin XXI</title>

    {{-- TailwindCSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 text-gray-900">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 bg-gray-900 text-gray-100 flex-shrink-0 flex flex-col p-5">
            <h4 class="text-yellow-400 font-bold text-xl text-center mb-8">🎬 Admin Panel</h4>

            {{-- Info User --}}
            <div class="bg-gray-800 p-3 rounded-lg mb-6 text-sm">
                <p class="font-semibold text-yellow-400">{{ auth()->user()->name ?? 'Admin' }}</p>
                <p class="text-gray-400">{{ auth()->user()->role->name ?? 'No Role' }}</p>
                <form action="{{ route('logout') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit"
                        class="text-red-400 hover:text-red-500 text-xs flex items-center gap-1">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>

            {{-- Navigasi --}}
            <nav class="flex-1 space-y-2 text-sm">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center px-3 py-2 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-yellow-400 text-gray-900 font-semibold' : 'hover:bg-yellow-400 hover:text-gray-900' }}">
                    <i class="fa-solid fa-house w-5 me-2"></i> Dashboard
                </a>
                <a href="{{ route('admin.cities.index') }}"
                   class="flex items-center px-3 py-2 rounded-lg transition {{ request()->routeIs('admin.cities.*') ? 'bg-yellow-400 text-gray-900 font-semibold' : 'hover:bg-yellow-400 hover:text-gray-900' }}">
                    <i class="fa-solid fa-city w-5 me-2"></i> Cities
                </a>
                <a href="{{ route('admin.cinemas.index') }}"
                   class="flex items-center px-3 py-2 rounded-lg transition {{ request()->routeIs('admin.cinemas.*') ? 'bg-yellow-400 text-gray-900 font-semibold' : 'hover:bg-yellow-400 hover:text-gray-900' }}">
                    <i class="fa-solid fa-building w-5 me-2"></i> Cinemas
                </a>
                <a href="{{ route('admin.studios.index') }}"
                   class="flex items-center px-3 py-2 rounded-lg transition {{ request()->routeIs('admin.studios.*') ? 'bg-yellow-400 text-gray-900 font-semibold' : 'hover:bg-yellow-400 hover:text-gray-900' }}">
                    <i class="fa-solid fa-tv w-5 me-2"></i> Studios
                </a>
                <a href="{{ route('admin.movies.index') }}"
                   class="flex items-center px-3 py-2 rounded-lg transition {{ request()->routeIs('admin.movies.*') ? 'bg-yellow-400 text-gray-900 font-semibold' : 'hover:bg-yellow-400 hover:text-gray-900' }}">
                    <i class="fa-solid fa-clapperboard w-5 me-2"></i> Movies
                </a>
                <a href="{{ route('admin.promos.index') }}"
                   class="flex items-center px-3 py-2 rounded-lg transition {{ request()->routeIs('admin.promos.*') ? 'bg-yellow-400 text-gray-900 font-semibold' : 'hover:bg-yellow-400 hover:text-gray-900' }}">
                    <i class="fa-solid fa-gift w-5 me-2"></i> Promos
                </a>
                <a href="{{ route('admin.tickets.index') }}"
                   class="flex items-center px-3 py-2 rounded-lg transition {{ request()->routeIs('admin.tickets.*') ? 'bg-yellow-400 text-gray-900 font-semibold' : 'hover:bg-yellow-400 hover:text-gray-900' }}">
                    <i class="fa-solid fa-ticket w-5 me-2"></i> Tickets
                </a>
                <a href="{{ route('admin.seats.index') }}"
                   class="flex items-center px-3 py-2 rounded-lg transition {{ request()->routeIs('admin.seats.*') ? 'bg-yellow-400 text-gray-900 font-semibold' : 'hover:bg-yellow-400 hover:text-gray-900' }}">
                    <i class="fa-solid fa-chair w-5 me-2"></i> Seats
                </a>
                <a href="{{ route('admin.orders.index') }}"
                   class="flex items-center px-3 py-2 rounded-lg transition {{ request()->routeIs('admin.orders.*') ? 'bg-yellow-400 text-gray-900 font-semibold' : 'hover:bg-yellow-400 hover:text-gray-900' }}">
                    <i class="fa-solid fa-receipt w-5 me-2"></i> Orders
                </a>

                {{-- Dropdown Manajemen User --}}
                @php
                    $userMenuActive = request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*');
                @endphp
                <details class="group" {{ $userMenuActive ? 'open' : '' }}>
                    <summary
                        class="flex justify-between items-center px-3 py-2 rounded-lg cursor-pointer hover:bg-yellow-400 hover:text-gray-900 transition {{ $userMenuActive ? 'bg-yellow-400 text-gray-900 font-semibold' : '' }}">
                        <span class="flex items-center">
                            <i class="fa-solid fa-users w-5 me-2"></i> Manajemen User
                        </span>
                        <i class="fa-solid fa-chevron-down text-xs transform group-open:rotate-180 transition"></i>
                    </summary>
                    <div class="ml-5 mt-2 space-y-1">
                        <a href="{{ route('admin.roles.index') }}"
                           class="flex items-center px-3 py-1 rounded-lg transition {{ request()->routeIs('admin.roles.*') ? 'bg-yellow-400 text-gray-900 font-semibold' : 'hover:bg-yellow-400 hover:text-gray-900' }}">
                            <i class="fa-solid fa-key w-4 me-2"></i> Roles
                        </a>
                        <a href="{{ route('admin.users.index') }}"
                           class="flex items-center px-3 py-1 rounded-lg transition {{ request()->routeIs('admin.users.*') ? 'bg-yellow-400 text-gray-900 font-semibold' : 'hover:bg-yellow-400 hover:text-gray-900' }}">
                            <i class="fa-solid fa-user-gear w-4 me-2"></i> Users
                        </a>
                    </div>
                </details>
            </nav>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 bg-white m-4 p-6 rounded-xl shadow-md overflow-auto">
            @yield('content')
        </main>
    </div>
</body>
</html>
