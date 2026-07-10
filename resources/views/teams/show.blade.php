@extends('layouts.app')
@section('title', $team->name)

@section('content')
<a href="{{ route('teams.index') }}" class="btn btn-sm btn-outline-secondary mb-3"><i class="bi bi-arrow-left"></i> Back to Teams</a>

<div class="card mb-4">
    <div class="card-body text-center">
        <img src="{{ $team->logo_url }}" class="team-logo-lg mb-3" alt="{{ $team->name }}">
        <h2>{{ $team->name }}</h2>
        <p class="text-muted">{{ $team->country }} &bull; Founded {{ $team->founded_year }}</p>
        <div class="row justify-content-center mt-3">
            <div class="col-md-3"><strong>Stadium:</strong> {{ $team->stadium }}</div>
            <div class="col-md-3"><strong>Coach:</strong> {{ $team->coach_name }}</div>
            <div class="col-md-3"><strong>Squad Size:</strong> {{ $team->players->count() }}</div>
        </div>
    </div>
</div>

<h4 class="mb-3">Squad</h4>
<div class="table-responsive">
    <table class="table table-hover">
        <thead><tr><th>#</th><th>Name</th><th>Position</th><th>Nationality</th></tr></thead>
        <tbody>
        @foreach($team->players as $player)
            <tr>
                <td>{{ $player->jersey_number }}</td>
                <td><a href="{{ route('players.show', $player) }}">{{ $player->name }}</a></td>
                <td>{{ $player->position }}</td>
                <td>{{ $player->nationality }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection