@extends('layouts.app')
@section('title', $player->name)

@section('content')
<a href="{{ route('players.index') }}" class="btn btn-sm btn-outline-secondary mb-3"><i class="bi bi-arrow-left"></i> Back to Players</a>

<div class="card mb-4">
    <div class="card-body text-center">
        <img src="{{ $player->photo_url }}" class="player-avatar-lg mb-3" alt="{{ $player->name }}">
        <h2>{{ $player->name }}</h2>
        <p class="text-muted">{{ $player->position }} &bull; {{ $player->team->name }} &bull; #{{ $player->jersey_number }}</p>
        <p><strong>Nationality:</strong> {{ $player->nationality }} &bull; <strong>DOB:</strong> {{ $player->date_of_birth }}</p>
    </div>
</div>

{{-- Player Analytics module --}}
<h4 class="mb-3"><i class="bi bi-graph-up"></i> Player Statistics</h4>
<div class="row g-3">
    @php $stat = $player->statistic; @endphp
    <div class="col-md-2 col-6"><div class="card stat-mini"><div class="card-body text-center"><h4>{{ $stat->matches_played ?? 0 }}</h4><small>Matches</small></div></div></div>
    <div class="col-md-2 col-6"><div class="card stat-mini"><div class="card-body text-center"><h4>{{ $stat->goals ?? 0 }}</h4><small>Goals</small></div></div></div>
    <div class="col-md-2 col-6"><div class="card stat-mini"><div class="card-body text-center"><h4>{{ $stat->assists ?? 0 }}</h4><small>Assists</small></div></div></div>
    <div class="col-md-2 col-6"><div class="card stat-mini"><div class="card-body text-center"><h4>{{ $stat->yellow_cards ?? 0 }}</h4><small>Yellow Cards</small></div></div></div>
    <div class="col-md-2 col-6"><div class="card stat-mini"><div class="card-body text-center"><h4>{{ $stat->red_cards ?? 0 }}</h4><small>Red Cards</small></div></div></div>
    <div class="col-md-2 col-6"><div class="card stat-mini"><div class="card-body text-center"><h4>{{ $stat->average_goals ?? 0 }}</h4><small>Avg Goals/Match</small></div></div></div>
</div>
@endsection