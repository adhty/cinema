<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    {{-- Navbar Atas --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    {{-- Link Navigasi Tambahan --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('movies.index') }}">Movies</a>
                    </li>

                    {{-- Dropdown User --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name ?? 'Admin' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Body: Sidebar + Konten --}}
    <div class="d-flex">
        {{-- Sidebar --}}
        <aside class="bg-dark text-white p-3" style="width:250px; min-height:100vh;">
            <h3 class="mb-4">Menu</h3>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link text-white">Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('cinemas.index') }}" class="nav-link text-white">Cinemas</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('cities.index') }}" class="nav-link text-white">Cities</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('studios.index') }}" class="nav-link text-white">Studios</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('movies.index') }}" class="nav-link text-white">Movies</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="#promoSubmenu" data-bs-toggle="collapse" class="nav-link text-white">Promos</a>
                    <ul class="collapse nav flex-column ms-3" id="promoSubmenu">
                        <li class="nav-item">
                            <a href="{{ route('promos.index') }}" class="nav-link text-white">All Promos</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('promos.index', ['status' => 'active']) }}" class="nav-link text-white">Active Promos</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('promos.index', ['status' => 'expired']) }}" class="nav-link text-white">Expired Promos</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </aside>

        {{-- Konten Utama --}}
        <main class="flex-grow-1 p-4 bg-light">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
