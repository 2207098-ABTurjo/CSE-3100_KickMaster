@if($errors->any())
    <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif
<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label class="form-label">Home Team</label>
        <select name="home_team_id" class="form-select" required>
            <option value="">Select Team</option>
            @foreach($teams as $team)
                <option value="{{ $team->id }}" {{ old('home_team_id', $fixture->home_team_id ?? '') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Away Team</label>
        <select name="away_team_id" class="form-select" required>
            <option value="">Select Team</option>
            @foreach($teams as $team)
                <option value="{{ $team->id }}" {{ old('away_team_id', $fixture->away_team_id ?? '') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Match Date & Time</label>
        <input type="datetime-local" name="match_date" class="form-control" value="{{ old('match_date', isset($fixture) ? $fixture->match_date->format('Y-m-d\TH:i') : '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Venue</label>
        <input type="text" name="venue" class="form-control" value="{{ old('venue', $fixture->venue ?? '') }}">
    </div>
    @if(isset($fixture))
    <div class="col-md-6">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            @foreach(['scheduled','completed','cancelled'] as $st)
                <option value="{{ $st }}" {{ old('status', $fixture->status) == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
            @endforeach
        </select>
    </div>
    @endif
</div>