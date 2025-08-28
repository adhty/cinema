@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center mb-4">
                <h2> Customer Information</h2>
                <p class="lead">Please fill in your details to complete the booking</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Booking Summary -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">🎫 Booking Summary</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>🎬 Movie:</strong> {{ $seat->ticket->movie->title ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>🏢 Cinema:</strong> {{ $seat->ticket->cinema->name ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>🎭 Studio:</strong> {{ $seat->ticket->studio->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>📅 Date:</strong> {{ \Carbon\Carbon::parse($seat->ticket->date)->format('d M Y') }}</p>
                            <p class="mb-1"><strong>🕐 Time:</strong> {{ $seat->ticket->time }}</p>
                            <p class="mb-1"><strong>🪑 Seat:</strong> <span class="badge bg-primary">{{ $seat->number }}</span></p>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <h4 class="text-primary mb-0">💰 Total: Rp {{ number_format($seat->ticket->price, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>

            <!-- Customer Form -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Customer Details</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('booking.process', $seat->id) }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name') }}" 
                                           placeholder="Enter your full name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email') }}" 
                                           placeholder="Enter your email" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    <input type="tel" name="phone" id="phone" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           value="{{ old('phone') }}" 
                                           placeholder="08xxxxxxxxxx" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror">
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="birthdate" class="form-label">Birth Date</label>
                                    <input type="date" name="birthdate" id="birthdate" 
                                           class="form-control @error('birthdate') is-invalid @enderror" 
                                           value="{{ old('birthdate') }}" 
                                           max="{{ date('Y-m-d') }}">
                                    @error('birthdate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Note:</strong> Your booking will be confirmed after completing this form. 
                            You will receive a confirmation email with payment instructions.
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('booking.select-seat', $seat->ticket_id) }}" class="btn btn-secondary">
                                ← Back to Seat Selection
                            </a>
                            <button type="submit" class="btn btn-success btn-lg">
                                🎫 Confirm Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-format phone number
document.getElementById('phone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.startsWith('0')) {
        value = value;
    } else if (value.startsWith('62')) {
        value = '0' + value.substring(2);
    }
    e.target.value = value;
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    
    if (!name || !email || !phone) {
        e.preventDefault();
        alert('Please fill in all required fields!');
        return false;
    }
    
    if (phone.length < 10) {
        e.preventDefault();
        alert('Please enter a valid phone number!');
        return false;
    }
    
    return confirm('Are you sure you want to confirm this booking?');
});
</script>
@endsection
