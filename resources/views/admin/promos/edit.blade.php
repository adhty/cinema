@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-8">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-800">✏️ Edit Promo</h1>
        <a href="{{ route('admin.promos.index') }}"
           class="inline-flex items-center bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition">
            ← Back
        </a>
    </div>

    {{-- Card Form --}}
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
        <form action="{{ route('admin.promos.update', $promo) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Cover --}}
            <div>
                <label for="cover" class="block font-semibold text-gray-700 mb-2">Cover Image</label>
                <div class="flex items-center space-x-4">
                    <input type="file" id="cover" name="cover"
                           class="block w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                           onchange="previewCover(event)">
                    @if($promo->cover)
                        <img id="coverPreview" src="{{ asset('storage/'.$promo->cover) }}" alt="{{ $promo->title }}"
                             class="w-32 h-24 object-cover rounded-lg shadow-sm border border-gray-200">
                    @else
                        <img id="coverPreview" class="w-32 h-24 object-cover rounded-lg hidden border border-gray-200">
                    @endif
                </div>
            </div>

            {{-- Title --}}
            <div>
                <label for="title" class="block font-semibold text-gray-700 mb-2">Title</label>
                <input type="text" id="title" name="title"
                       value="{{ old('title', $promo->title) }}" required
                       class="block w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>

            {{-- Deadline --}}
            <div>
                <label for="deadline" class="block font-semibold text-gray-700 mb-2">Deadline</label>
                <input type="date" id="deadline" name="deadline"
                       value="{{ old('deadline', $promo->deadline->format('Y-m-d')) }}" required
                       class="block w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block font-semibold text-gray-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="4"
                          class="block w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none resize-none">{{ old('description', $promo->description) }}</textarea>
            </div>

            {{-- Term & Condition --}}
            <div>
                <label for="term_condition" class="block font-semibold text-gray-700 mb-2">Terms & Conditions</label>
                <textarea id="term_condition" name="term_condition" rows="4"
                          class="block w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none resize-none">{{ old('term_condition', $promo->term_condition) }}</textarea>
            </div>

            {{-- Buttons --}}
            <div class="flex items-center space-x-3 pt-4">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2.5 rounded-lg transition">
                    💾 Update Promo
                </button>
                <a href="{{ route('admin.promos.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white font-medium px-5 py-2.5 rounded-lg transition">
                    ✖ Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function previewCover(event) {
        const input = event.target;
        const preview = document.getElementById('coverPreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
