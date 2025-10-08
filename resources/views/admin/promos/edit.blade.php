@extends('layouts/admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Promo</h1>
        <a href="{{ route('admin.promos.index') }}" class="btn btn-secondary">Back to Promos</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Promo Form</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.promos.update', $promo) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="cover">Cover Image</label>
                    <input type="file" class="form-control" id="cover" name="cover">
                    @if ($promo->cover)
                        <img src="{{ asset('storage/' . $promo->cover) }}" alt="{{ $promo->title }}" width="100" class="mt-2">
                    @endif
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $promo->title) }}" required>
                </div>
                <div class="form-group">
                    <label for="deadline">Deadline</label>
                    <input type="date" class="form-control" id="deadline" name="deadline" value="{{ old('deadline', $promo->deadline->format('Y-m-d')) }}" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $promo->description) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="term_condition">Term & Condition</label>
                    <textarea class="form-control" id="term_condition" name="term_condition" rows="3">{{ old('term_condition', $promo->term_condition) }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update Promo</button>
            </form>
        </div>
    </div>
</div>
@endsection