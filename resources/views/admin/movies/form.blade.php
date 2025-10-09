{{-- Title --}}
<div class="mb-4">
    <label for="title" class="block font-medium text-gray-700 mb-1">Title</label>
    <input type="text" id="title" name="title" 
           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300 @error('title') border-red-500 @enderror" 
           value="{{ old('title', $movie->title ?? '') }}" required>
    @error('title')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- Duration, Age, Animation Type --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
    <div>
        <label for="duration" class="block font-medium text-gray-700 mb-1">Duration (minutes)</label>
        <input type="number" id="duration" name="duration" 
               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300 @error('duration') border-red-500 @enderror" 
               value="{{ old('duration', $movie->duration ?? '') }}" required>
        @error('duration')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="age" class="block font-medium text-gray-700 mb-1">Age Rating</label>
        <input type="number" id="age" name="age" 
               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300 @error('age') border-red-500 @enderror" 
               value="{{ old('age', $movie->age ?? '') }}" required>
        @error('age')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="animation_type" class="block font-medium text-gray-700 mb-1">Animation Type</label>
        <input type="text" id="animation_type" name="animation_type" 
               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300 @error('animation_type') border-red-500 @enderror" 
               value="{{ old('animation_type', $movie->animation_type ?? '') }}">
        @error('animation_type')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

{{-- Trailer --}}
<div class="mb-4">
    <label for="trailer" class="block font-medium text-gray-700 mb-1">Trailer URL</label>
    <input type="text" id="trailer" name="trailer"
           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300 @error('trailer') border-red-500 @enderror"
           value="{{ old('trailer', $movie->trailer ?? '') }}">
    @error('trailer')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- Start Showing & Selling --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
    <div>
        <label for="start_showing" class="block font-medium text-gray-700 mb-1">Start Showing</label>
        <input type="date" id="start_showing" name="start_showing" 
               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300 @error('start_showing') border-red-500 @enderror"
               value="{{ old('start_showing', $movie->start_showing ?? '') }}">
        @error('start_showing')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="start_selling" class="block font-medium text-gray-700 mb-1">Start Selling</label>
        <input type="date" id="start_selling" name="start_selling" 
               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300 @error('start_selling') border-red-500 @enderror"
               value="{{ old('start_selling', $movie->start_selling ?? '') }}">
        @error('start_selling')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

{{-- Synopsis --}}
<div class="mb-4">
    <label for="synopsis" class="block font-medium text-gray-700 mb-1">Synopsis</label>
    <textarea id="synopsis" name="synopsis" rows="4" 
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300 @error('synopsis') border-red-500 @enderror">{{ old('synopsis', $movie->synopsis ?? '') }}</textarea>
    @error('synopsis')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- Producer, Director, Writer, Production --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
    <div>
        <label for="producer" class="block font-medium text-gray-700 mb-1">Producer</label>
        <input type="text" id="producer" name="producer"
               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300 @error('producer') border-red-500 @enderror"
               value="{{ old('producer', $movie->producer ?? '') }}">
        @error('producer')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="director" class="block font-medium text-gray-700 mb-1">Director</label>
        <input type="text" id="director" name="director"
               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300 @error('director') border-red-500 @enderror"
               value="{{ old('director', $movie->director ?? '') }}">
        @error('director')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
    <div>
        <label for="writer" class="block font-medium text-gray-700 mb-1">Writer</label>
        <input type="text" id="writer" name="writer"
               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300 @error('writer') border-red-500 @enderror"
               value="{{ old('writer', $movie->writer ?? '') }}">
        @error('writer')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="production" class="block font-medium text-gray-700 mb-1">Production</label>
        <input type="text" id="production" name="production"
               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300 @error('production') border-red-500 @enderror"
               value="{{ old('production', $movie->production ?? '') }}">
        @error('production')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

{{-- Cover Upload --}}
<div class="mb-4">
    <label for="cover" class="block font-medium text-gray-700 mb-1">Cover</label>
    <input type="file" id="cover" name="cover" accept="image/*" onchange="previewCover(event)"
           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300 @error('cover') border-red-500 @enderror">
    @error('cover')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror

    <div class="mt-2">
        <img id="coverPreview" 
             src="{{ isset($movie) && $movie->cover ? asset('storage/'.$movie->cover) : '' }}" 
             alt="Cover Preview" 
             class="rounded border {{ isset($movie) && $movie->cover ? '' : 'hidden' }}" 
             style="max-height: 150px;">
    </div>
</div>

@push('scripts')
<script>
    function previewCover(event) {
        const coverInput = event.target;
        const preview = document.getElementById('coverPreview');

        if (coverInput.files && coverInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(coverInput.files[0]);
        }
    }
</script>
@endpush
