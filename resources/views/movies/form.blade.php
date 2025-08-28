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

<div class="mb-3">
    <label class="form-label">Actors</label>
    <div id="actors-container" data-actor-count="{{ isset($movie) && $movie->actors->count() > 0 ? $movie->actors->count() : 1 }}">
        @if(isset($movie) && $movie->actors->count() > 0)
            @foreach($movie->actors as $index => $actor)
                <div class="actor-row mb-3 p-3 border rounded" data-actor-index="{{ $index }}">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Actor Name</label>
                            <input type="text" name="actors[{{ $index }}][name]" value="{{ $actor->name }}" class="form-control" placeholder="Actor Name">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Character Name</label>
                            <input type="text" name="actors[{{ $index }}][character_name]" value="{{ $actor->character_name }}" class="form-control" placeholder="Character Name">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Photo</label>
                            <input type="file" name="actors[{{ $index }}][photo]" class="form-control">
                            @if($actor->photo)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/'.$actor->photo) }}" class="img-thumbnail" style="max-width: 100px; height: auto;">
                                    <input type="hidden" name="actors[{{ $index }}][existing_photo]" value="{{ $actor->photo }}">
                                </div>
                            @endif
                            <input type="hidden" name="actors[{{ $index }}][id]" value="{{ $actor->id }}">
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <button type="button" class="btn btn-danger remove-actor w-100">Remove</button>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="actor-row mb-3 p-3 border rounded" data-actor-index="0">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Actor Name</label>
                        <input type="text" name="actors[0][name]" class="form-control" placeholder="Actor Name">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Character Name</label>
                        <input type="text" name="actors[0][character_name]" class="form-control" placeholder="Character Name">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Photo</label>
                        <input type="file" name="actors[0][photo]" class="form-control">
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" class="btn btn-danger remove-actor w-100">Remove</button>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <button type="button" id="add-actor" class="btn btn-secondary">Add Another Actor</button>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the initial actor count from a data attribute
        const actorsContainer = document.getElementById('actors-container');
        let actorIndex = parseInt(actorsContainer.dataset.actorCount || '1');
        
        // Add actor button
        document.getElementById('add-actor').addEventListener('click', function() {
            const container = document.getElementById('actors-container');
            const newRow = document.createElement('div');
            newRow.className = 'actor-row mb-3 p-3 border rounded';
            newRow.setAttribute('data-actor-index', actorIndex);
            newRow.innerHTML = `
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Actor Name</label>
                        <input type="text" name="actors[${actorIndex}][name]" class="form-control" placeholder="Actor Name">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Character Name</label>
                        <input type="text" name="actors[${actorIndex}][character_name]" class="form-control" placeholder="Character Name">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Photo</label>
                        <input type="file" name="actors[${actorIndex}][photo]" class="form-control">
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" class="btn btn-danger remove-actor w-100">Remove</button>
                    </div>
                </div>
            `;
            container.appendChild(newRow);
            actorIndex++;
            
            // Add event listener to the new remove button
            newRow.querySelector('.remove-actor').addEventListener('click', function() {
                container.removeChild(newRow);
            });
        });
        
        // Remove actor buttons
        document.querySelectorAll('.remove-actor').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('.actor-row');
                row.parentNode.removeChild(row);
            });
        });
    });
</script>
@endsection

@yield('scripts')
