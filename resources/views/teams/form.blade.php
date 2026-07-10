{{-- Ei partial create ar edit dujaigatei reuse kora hoyeche --}}
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
@endif

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label class="form-label">Team Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $team->name ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Short Name</label>
        <input type="text" name="short_name" class="form-control" maxlength="10" value="{{ old('short_name', $team->short_name ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Country</label>
        <input type="text" name="country" class="form-control" value="{{ old('country', $team->country ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Founded Year</label>
        <input type="number" name="founded_year" class="form-control" value="{{ old('founded_year', $team->founded_year ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Stadium</label>
        <input type="text" name="stadium" class="form-control" value="{{ old('stadium', $team->stadium ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Coach Name</label>
        <input type="text" name="coach_name" class="form-control" value="{{ old('coach_name', $team->coach_name ?? '') }}">
    </div>
    <div class="col-md-12">
        <label class="form-label">Logo URL</label>
        <input type="url" name="logo_url" class="form-control" value="{{ old('logo_url', $team->logo_url ?? '') }}">
    </div>
</div>