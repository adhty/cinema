@extends('layouts.admin')

@section('title', 'Edit Cinema')

@section('content')
<div class="container mx-auto py-4">
    <h2 class="text-2xl font-bold mb-4">Edit Cinema</h2>

    {{-- Error --}}
    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc list-inside mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.cinemas.update', $cinema->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        {{-- Cover Image --}}
        <div>
            <label class="block mb-1 font-medium">Cover Image (biarkan kosong jika tidak ganti)</label>
            <input type="file" name="cover" accept="image/*" id="coverInput"
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
            
            @if($cinema->image)
            <div class="mt-2">
                <small>Current:</small><br>
                <img src="{{ asset('storage/'.$cinema->image) }}" id="coverPreview" class="w-36 rounded shadow mt-2">
            </div>
            @else
            <img id="coverPreview" class="w-36 rounded shadow mt-2 hidden">
            @endif
        </div>

        {{-- Cinema Name --}}
        <div>
            <label class="block mb-1 font-medium">Cinema Name</label>
            <input type="text" name="name" value="{{ old('name', $cinema->name) }}" required
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
        </div>

        {{-- Address --}}
        <div>
            <label class="block mb-1 font-medium">Address</label>
            <input type="text" name="address" value="{{ old('address', $cinema->address) }}" required
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
        </div>

        {{-- City --}}
        <div>
            <label class="block mb-1 font-medium">City</label>
            <select name="city_id" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                <option value="">-- Pilih Kota --</option>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}" {{ old('city_id', $cinema->city_id) == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Buttons --}}
        <div class="flex space-x-2">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Update
            </button>
            <a href="{{ route('admin.cinemas.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">
                Batal
            </a>
        </div>
    </form>
</div>

{{-- Preview Image Script --}}
@push('scripts')
<script>
    const coverInput = document.getElementById('coverInput');
    const coverPreview = document.getElementById('coverPreview');

    coverInput.addEventListener('change', function(e) {
        const [file] = coverInput.files;
        if (file) {
            coverPreview.src = URL.createObjectURL(file);
            coverPreview.classList.remove('hidden');
        }
    });
</script>
@endpush

@endsection
