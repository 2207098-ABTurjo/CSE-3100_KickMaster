@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label class="form-label">Full Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $player->name ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Team</label>
        <select name="team_id" class="form-select" required>
            <option value="">Select Team</option>
            @foreach($teams as $team)
                <option value="{{ $team->id }}" {{ old('team_id', $player->team_id ?? '') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Position</label>
        <select name="position" class="form-select" required>
            @foreach(['Goalkeeper','Defender','Midfielder','Forward'] as $pos)
                <option value="{{ $pos }}" {{ old('position', $player->position ?? '') == $pos ? 'selected' : '' }}>{{ $pos }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Jersey Number</label>
        <input type="number" name="jersey_number" class="form-control" min="1" max="99" value="{{ old('jersey_number', $player->jersey_number ?? '') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Nationality</label>
        <input type="text" name="nationality" class="form-control" value="{{ old('nationality', $player->nationality ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Date of Birth</label>
        <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', $player->date_of_birth ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Photo URL</label>
        <input type="url" name="photo_url" class="form-control" value="{{ old('photo_url', $player->photo_url ?? '') }}">
    </div>
</div>