@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Create Promo</h1>
        <a href="{{ route('admin.promos.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Back to Promos</a>
    </div>

    {{-- Card Form --}}
    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('admin.promos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            {{-- Cover --}}
            <div>
                <label for="cover" class="block font-medium text-gray-700 mb-1">Cover Image</label>
                <input type="file" id="cover" name="cover" class="block w-full border border-gray-300 rounded-md p-2"
                       onchange="previewCover(event)">
                <img id="coverPreview" class="mt-2 w-32 h-24 object-cover rounded-md hidden" alt="Cover Preview">
            </div>

            {{-- Title --}}
            <div>
                <label for="title" class="block font-medium text-gray-700 mb-1">Title</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required
                       class="block w-full border border-gray-300 rounded-md p-2">
            </div>

            {{-- Deadline --}}
            <div>
                <label for="deadline" class="block font-medium text-gray-700 mb-1">Deadline</label>
                <input type="date" id="deadline" name="deadline" value="{{ old('deadline') }}" required
                       class="block w-full border border-gray-300 rounded-md p-2">
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block font-medium text-gray-700 mb-1">Description</label>
                <textarea id="description" name="description" rows="3"
                          class="block w-full border border-gray-300 rounded-md p-2">{{ old('description') }}</textarea>
            </div>

            {{-- Term & Condition --}}
            <div>
                <label for="term_condition" class="block font-medium text-gray-700 mb-1">Term & Condition</label>
                <textarea id="term_condition" name="term_condition" rows="3"
                          class="block w-full border border-gray-300 rounded-md p-2">{{ old('term_condition') }}</textarea>
            </div>

            {{-- Buttons --}}
            <div class="flex space-x-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Create Promo</button>
                <a href="{{ route('admin.promos.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Cancel</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function previewCover(event) {
        const input = event.target;
        const preview = document.getElementById('coverPreview');
        if(input.files && input.files[0]){
            const reader = new FileReader();
            reader.onload = function(e){
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
