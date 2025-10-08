@extends('layouts/admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Promo Details</h1>
        <a href="{{ route('admin.promos.index') }}" class="btn btn-secondary">Back to Promos</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Promo Information</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    @if ($promo->cover)
                        <img src="{{ asset('storage/' . $promo->cover) }}" alt="{{ $promo->title }}" class="img-fluid">
                    @else
                        <p>No Image</p>
                    @endif
                </div>
                <div class="col-md-8">
                    <h2>{{ $promo->title }}</h2>
                    <p><strong>Deadline:</strong> {{ $promo->deadline->format('d M Y') }}</p>
                    <p><strong>Description:</strong></p>
                    <p>{{ $promo->description ?? 'No description' }}</p>
                    <p><strong>Term & Condition:</strong></p>
                    <p>{{ $promo->term_condition ?? 'No term & condition' }}</p>
                    <a href="{{ route('admin.promos.edit', $promo) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.promos.destroy', $promo) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection