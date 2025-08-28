@csrf

<div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name"
           value="{{ old('name', $actor->name ?? '') }}"
           class="form-control @error('name') is-invalid @enderror">
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Character Name</label>
    <input type="text" name="character_name"
           value="{{ old('character_name', $actor->character_name ?? '') }}"
           class="form-control @error('character_name') is-invalid @enderror">
    @error('character_name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Photo</label>
    <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
    <div class="form-text">Allowed file types: JPEG, PNG, JPG, GIF. Max size: 2MB.</div>
    @error('photo')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    @if(isset($actor) && $actor->photo)
        <div class="mt-2">
            <img src="{{ asset('storage/'.$actor->photo) }}" class="img-thumbnail" style="max-width: 200px; height: auto;">
        </div>
    @endif
</div>

<button type="submit" class="btn btn-primary">
    {{ isset($actor) ? 'Update Actor' : 'Save Actor' }}
</button>
