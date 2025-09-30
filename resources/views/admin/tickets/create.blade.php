@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🎫 Create New Ticket</h2>
        <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">← Back to Tickets</a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Ticket Information</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.tickets.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="movie_id" class="form-label">Movie <span class="text-danger">*</span></label>
                                    <select name="movie_id" id="movie_id" class="form-select @error('movie_id') is-invalid @enderror" required>
                                        <option value="">Select Movie</option>
                                        @foreach($movies as $movie)
                                            <option value="{{ $movie->id }}" {{ old('movie_id') == $movie->id ? 'selected' : '' }}>
                                                {{ $movie->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('movie_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cinema_id" class="form-label">Cinema <span class="text-danger">*</span></label>
                                    <select name="cinema_id" id="cinema_id" class="form-select @error('cinema_id') is-invalid @enderror" required>
                                        <option value="">Select Cinema</option>
                                        @foreach($cinemas as $cinema)
                                            <option value="{{ $cinema->id }}" {{ old('cinema_id') == $cinema->id ? 'selected' : '' }}>
                                                {{ $cinema->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cinema_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="studio_id" class="form-label">Studio <span class="text-danger">*</span></label>
                                    <select name="studio_id" id="studio_id" class="form-select @error('studio_id') is-invalid @enderror" required>
                                        <option value="">Select Studio</option>
                                        @foreach($studios as $studio)
                                            <option value="{{ $studio->id }}" {{ old('studio_id') == $studio->id ? 'selected' : '' }}>
                                                {{ $studio->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('studio_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="city_id" class="form-label">City <span class="text-danger">*</span></label>
                                    <select name="city_id" id="city_id" class="form-select @error('city_id') is-invalid @enderror" required>
                                        <option value="">Select City</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('city_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                                    <input type="date" name="date" id="date" 
                                           class="form-control @error('date') is-invalid @enderror" 
                                           value="{{ old('date') }}" 
                                           min="{{ date('Y-m-d') }}" required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="time" class="form-label">Time <span class="text-danger">*</span></label>
                                    <input type="time" name="time" id="time" 
                                           class="form-control @error('time') is-invalid @enderror" 
                                           value="{{ old('time') }}" required>
                                    @error('time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" name="price" id="price" 
                                           class="form-control @error('price') is-invalid @enderror" 
                                           value="{{ old('price') }}" 
                                           min="0" step="1000" 
                                           placeholder="50000" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="create_seats" name="create_seats" value="1" checked>
                                <label class="form-check-label" for="create_seats">
                                    Auto-create seats for this ticket (A1-A5, B1-B5, C1-C5)
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Ticket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-populate related fields based on selection
document.getElementById('cinema_id').addEventListener('change', function() {
    const cinemaId = this.value;
    if (cinemaId) {
        // You can add AJAX call here to filter studios by cinema
        console.log('Cinema selected:', cinemaId);
    }
});

// Set default time suggestions
document.addEventListener('DOMContentLoaded', function() {
    const timeInput = document.getElementById('time');
    if (!timeInput.value) {
        // Suggest common movie times
        const commonTimes = ['10:00', '13:00', '16:00', '19:00', '21:30'];
        const now = new Date();
        const currentHour = now.getHours();
        
        // Suggest next available time slot
        for (let time of commonTimes) {
            const [hour] = time.split(':');
            if (parseInt(hour) > currentHour) {
                timeInput.value = time;
                break;
            }
        }
    }
});
</script>
@endsection
