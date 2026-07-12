@extends('layouts.app')
@section('title', 'Players')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-people"></i> Players</h2>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.players.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add Player</a>
    @endif
</div>

{{-- Search ar filter form --}}
<form method="GET" class="row g-2 mb-4">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Search player name..." value="{{ request('search') }}">
    </div>
    <div class="col-md-3">
        <select name="team_id" class="form-select">
            <option value="">All Teams</option>
            @foreach($teams as $team)
                <option value="{{ $team->id }}" {{ request('team_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <select name="position" class="form-select">
            <option value="">All Positions</option>
            @foreach(['Goalkeeper','Defender','Midfielder','Forward'] as $pos)
                <option value="{{ $pos }}" {{ request('position') == $pos ? 'selected' : '' }}>{{ $pos }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-outline-secondary w-100"><i class="bi bi-funnel"></i> Filter</button>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead><tr><th>Photo</th><th>Name</th><th>Team</th><th>Position</th><th>Jersey#</th><th>Goals</th>@if(auth()->user()->isAdmin())<th>Action</th>@endif</tr></thead>
        <tbody>
        @forelse($players as $player)
            <tr>
                <td><img src="{{ $player->photo_url }}" class="player-avatar" alt="{{ $player->name }}"></td>
                <td><a href="{{ route('players.show', $player) }}">{{ $player->name }}</a></td>
                <td>{{ $player->team->name }}</td>
                <td>{{ $player->position }}</td>
                <td>{{ $player->jersey_number }}</td>
                <td>{{ $player->statistic->goals ?? 0 }}</td>
                @if(auth()->user()->isAdmin())
                <td>
                    <a href="{{ route('admin.players.edit', $player) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.players.destroy', $player) }}" method="POST" class="d-inline delete-form">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
                @endif
            </tr>
        @empty
            <tr><td colspan="7" class="text-center text-muted">No players found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $players->links() }}</div>
@endsection