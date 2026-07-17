@extends('layouts.app')
@section('title', 'Matches')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-broadcast"></i> Matches / Live Score</h2>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.matches.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add Match</a>
    @endif
</div>

<form method="GET" class="row g-2 mb-4">
    <div class="col-md-3">
        <select name="team_id" class="form-select">
            <option value="">All Teams</option>
            @foreach($teams as $team)
                <option value="{{ $team->id }}" {{ request('team_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">All Status</option>
            @foreach(['upcoming','live','completed'] as $st)
                <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-outline-secondary w-100"><i class="bi bi-funnel"></i> Filter</button>
    </div>
</form>

<div class="row g-3">
    @forelse($matches as $match)
        <div class="col-md-6">
            <div class="card match-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">{{ $match->match_date->format('d M Y') }}</small>
                        @if($match->status == 'live')
                            <span class="badge bg-danger live-badge">LIVE</span>
                        @else
                            <span class="badge bg-{{ $match->status == 'completed' ? 'success' : 'secondary' }}">{{ ucfirst($match->status) }}</span>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <span class="fw-bold">{{ $match->homeTeam->short_name }}</span>
                        <span class="fs-4 fw-bold">{{ $match->home_score }} - {{ $match->away_score }}</span>
                        <span class="fw-bold">{{ $match->awayTeam->short_name }}</span>
                    </div>
                    <div class="text-center mt-2">
                        <a href="{{ route('matches.show', $match) }}" class="btn btn-sm btn-outline-primary">Details</a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.matches.edit', $match) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                            <a href="{{ route('admin.matches.statistics.edit', $match) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-bar-chart"></i></a>
                            <form action="{{ route('admin.matches.destroy', $match) }}" method="POST" class="d-inline delete-form">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">No matches found.</p>
    @endforelse
</div>
<div class="mt-3">{{ $matches->links() }}</div>
@endsection