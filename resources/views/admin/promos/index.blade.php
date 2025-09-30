@extends('layouts/admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Promos</h1>
        <a href="{{ route('admin.promos.create') }}" class="btn btn-primary">Add New Promo</a>
    </div>
    
    <!-- Promo Navigation Bar -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link {{ $status == 'all' || is_null($status) ? 'active' : '' }}"
               href="{{ route('admin.promos.index', ['status' => 'all']) }}">All Promos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status == 'active' ? 'active' : '' }}"
               href="{{ route('admin.promos.index', ['status' => 'active']) }}">Active Promos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status == 'expired' ? 'active' : '' }}"
               href="{{ route('admin.promos.index', ['status' => 'expired']) }}">Expired Promos</a>
        </li>
    </ul>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Promo List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Cover</th>
                            <th>Title</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($promos as $promo)
                        <tr>
                            <td>
                                @if ($promo->cover)
                                    <img src="{{ asset('storage/' . $promo->cover) }}" alt="{{ $promo->title }}" width="100">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td>{{ $promo->title }}</td>
                            <td>{{ $promo->deadline->format('d M Y') }}</td>
                            <td>
                                @if ($promo->deadline >= now())
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Expired</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.promos.show', $promo) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('admin.promos.edit', $promo) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.promos.destroy', $promo) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
