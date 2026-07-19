@extends('layouts.app')
@section('title', 'Search Results')

@section('content')
<h2 class="mb-4"><i class="bi bi-search"></i> Search Results for "{{ $keyword }}"</h2>

<h5>Teams</h5>
<ul class="list-group mb-4">
    @forelse($teams as $team)
        <li class="list-group-item"><a href="{{ route('teams.show', $team) }}">{{ $team->name }}</a></li>
    @empty
        <li class="list-group-item text-muted">No teams found.</li>
    @endforelse
</ul>

<h5>Players</h5>
<ul class="list-group mb-4">
    @forelse($players as $player)
        <li class="list-group-item"><a href="{{ route('players.show', $player) }}">{{ $player->name }}</a> - {{ $player->team->name }}</li>
    @empty
        <li class="list-group-item text-muted">No players found.</li>
    @endforelse
</ul>

<h5>Matches</h5>
<ul class="list-group">
    @forelse($matches as $match)
        <li class="list-group-item"><a href="{{ route('matches.show', $match) }}">{{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}</a></li>
    @empty
        <li class="list-group-item text-muted">No matches found.</li>
    @endforelse
</ul>
@endsection