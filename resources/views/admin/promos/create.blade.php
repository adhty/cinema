@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-10">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-800 tracking-tight">✨ Create New Promo</h1>
        <a href="{{ route('admin.promos.index') }}" 
           class="inline-flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow transition duration-200">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>

    {{-- Card Form --}}
    <div class="bg-white border border-gray-100 shadow-lg rounded-2xl p-8 md:p-10">
        <form action="{{ route('admin.promos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Cover Image --}}
            <div>
                <label for="cover" class="block text-sm font-semibold text-gray-700 mb-2">
                    Cover Image
                </label>
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <img id="coverPreview" 
                             class="w-40 h-28 object-cover rounded-lg border border-gray-300 shadow-sm hidden" 
                             alt="Cover Preview">
                        <div id="noImage" 
                             class="w-40 h-28 flex items-center justify-center border border-dashed border-gray-300 text-gray-400 rounded-lg bg-gray-50">
                             No Image
                        </div>
                    </div>
                    <input type="file" id="cover" name="cover" 
                           class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                           onchange="previewCover(event)">
                </div>
            </div>

            {{-- Title --}}
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Promo Title</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none placeholder-gray-400"
                       placeholder="Enter promo title">
            </div>

            {{-- Deadline --}}
            <div>
                <label for="deadline" class="block text-sm font-semibold text-gray-700 mb-2">Deadline</label>
                <input type="date" id="deadline" name="deadline" value="{{ old('deadline') }}" required
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="3"
                          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none placeholder-gray-400"
                          placeholder="Write promo description here...">{{ old('description') }}</textarea>
            </div>

            {{-- Term & Condition --}}
            <div>
                <label for="term_condition" class="block text-sm font-semibold text-gray-700 mb-2">Terms & Conditions</label>
                <textarea id="term_condition" name="term_condition" rows="3"
                          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none placeholder-gray-400"
                          placeholder="Enter promo terms & conditions...">{{ old('term_condition') }}</textarea>
            </div>

            {{-- Buttons --}}
            <div class="flex items-center gap-4 pt-4">
                <button type="submit" 
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg shadow transition duration-200">
                    <i class="fa-solid fa-plus"></i> Create Promo
                </button>
                <a href="{{ route('admin.promos.index') }}" 
                   class="inline-flex items-center gap-2 bg-gray-400 hover:bg-gray-500 text-white font-semibold px-5 py-2 rounded-lg shadow transition duration-200">
                    <i class="fa-solid fa-xmark"></i> Cancel
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
        const noImage = document.getElementById('noImage');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                noImage.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.classList.add('hidden');
            noImage.classList.remove('hidden');
        }
    }
</script>
@endpush
@endsection
