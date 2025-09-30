<div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" 
           id="title" name="title" value="{{ old('title', $movie->title ?? '') }}" required>
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-4">
        <div class="mb-3">
            <label for="duration" class="form-label">Duration (minutes)</label>
            <input type="number" class="form-control @error('duration') is-invalid @enderror" 
                   id="duration" name="duration" value="{{ old('duration', $movie->duration ?? '') }}" required>
            @error('duration')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="age" class="form-label">Age Rating</label>
            <input type="number" class="form-control @error('age') is-invalid @enderror" 
                   id="age" name="age" value="{{ old('age', $movie->age ?? '') }}" required>
            @error('age')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="animation_type" class="form-label">Animation Type</label>
            <input type="text" class="form-control @error('animation_type') is-invalid @enderror" 
                   id="animation_type" name="animation_type" value="{{ old('animation_type', $movie->animation_type ?? '') }}">
            @error('animation_type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="mb-3">
    <label for="trailer" class="form-label">Trailer URL</label>
    <input type="text" class="form-control @error('trailer') is-invalid @enderror" 
           id="trailer" name="trailer" value="{{ old('trailer', $movie->trailer ?? '') }}">
    @error('trailer')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="start_showing" class="form-label">Start Showing</label>
            <input type="date" class="form-control @error('start_showing') is-invalid @enderror" 
                   id="start_showing" name="start_showing" value="{{ old('start_showing', $movie->start_showing ?? '') }}">
            @error('start_showing')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="start_selling" class="form-label">Start Selling</label>
            <input type="date" class="form-control @error('start_selling') is-invalid @enderror" 
                   id="start_selling" name="start_selling" value="{{ old('start_selling', $movie->start_selling ?? '') }}">
            @error('start_selling')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="mb-3">
    <label for="synopsis" class="form-label">Synopsis</label>
    <textarea class="form-control @error('synopsis') is-invalid @enderror" 
              id="synopsis" name="synopsis" rows="4">{{ old('synopsis', $movie->synopsis ?? '') }}</textarea>
    @error('synopsis')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="producer" class="form-label">Producer</label>
            <input type="text" class="form-control @error('producer') is-invalid @enderror" 
                   id="producer" name="producer" value="{{ old('producer', $movie->producer ?? '') }}">
            @error('producer')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="director" class="form-label">Director</label>
            <input type="text" class="form-control @error('director') is-invalid @enderror" 
                   id="director" name="director" value="{{ old('director', $movie->director ?? '') }}">
            @error('director')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="writer" class="form-label">Writer</label>
            <input type="text" class="form-control @error('writer') is-invalid @enderror" 
                   id="writer" name="writer" value="{{ old('writer', $movie->writer ?? '') }}">
            @error('writer')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="production" class="form-label">Production</label>
            <input type="text" class="form-control @error('production') is-invalid @enderror" 
                   id="production" name="production" value="{{ old('production', $movie->production ?? '') }}">
            @error('production')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>