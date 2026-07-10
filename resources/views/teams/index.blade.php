@extends('layouts.app')
@section('title', 'Teams')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-shield"></i> Teams</h2>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.teams.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add Team</a>
    @endif
</div>

{{-- Search form - team name diye filter kore --}}
<form method="GET" class="mb-4">
    <div class="input-group" style="max-width:400px;">
        <input type="text" name="search" class="form-control" placeholder="Search team name..." value="{{ request('search') }}">
        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
    </div>
</form>

<div class="row g-4">
    @forelse($teams as $team)
        <div class="col-md-4">
            <div class="card team-card h-100">
                <div class="card-body text-center">
                    <img src="{{ $team->logo_url }}" alt="{{ $team->name }}" class="team-logo mb-2">
                    <h5 class="card-title">{{ $team->name }}</h5>
                    <p class="text-muted mb-1">{{ $team->country }}</p>
                    <p class="small text-muted">{{ $team->players_count }} Players</p>
                    <a href="{{ route('teams.show', $team) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.teams.edit', $team) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.teams.destroy', $team) }}" method="POST" class="d-inline delete-form">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">No teams found.</p>
    @endforelse
</div>

<div class="mt-4">{{ $teams->links() }}</div>
@endsection