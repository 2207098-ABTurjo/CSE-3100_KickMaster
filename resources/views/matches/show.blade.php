@extends('layouts.app')
@section('title', 'Match Details')

@section('content')
<a href="{{ route('matches.index') }}" class="btn btn-sm btn-outline-secondary mb-3"><i class="bi bi-arrow-left"></i> Back to Matches</a>

<div class="card mb-4" id="scoreCard" data-match-id="{{ $match->id }}">
    <div class="card-body text-center">
        <p class="text-muted mb-1">{{ $match->match_date->format('d M Y, h:i A') }} &bull; {{ $match->venue }}</p>
        <div class="row align-items-center">
            <div class="col-5 text-end"><h4>{{ $match->homeTeam->name }}</h4></div>
            <div class="col-2">
                <h2 id="scoreDisplay">{{ $match->home_score }} - {{ $match->away_score }}</h2>
            </div>
            <div class="col-5 text-start"><h4>{{ $match->awayTeam->name }}</h4></div>
        </div>
        <span class="badge bg-info" id="statusBadge">{{ ucfirst($match->status) }}</span>

        @if(auth()->user()->isAdmin())
            {{-- Live score update button - AJAX diye kaj kore, page reload hoy na --}}
            <div class="mt-4 p-3 border rounded">
                <h6>Update Live Score</h6>
                <form id="scoreUpdateForm" class="row g-2 justify-content-center align-items-center">
                    @csrf
                    <div class="col-auto">
                        <input type="number" min="0" id="homeScoreInput" class="form-control" style="width:80px" value="{{ $match->home_score }}">
                    </div>
                    <div class="col-auto">-</div>
                    <div class="col-auto">
                        <input type="number" min="0" id="awayScoreInput" class="form-control" style="width:80px" value="{{ $match->away_score }}">
                    </div>
                    <div class="col-auto">
                        <select id="statusInput" class="form-select">
                            @foreach(['upcoming','live','completed'] as $st)
                                <option value="{{ $st }}" {{ $match->status == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-success"><i class="bi bi-arrow-repeat"></i> Update</button>
                    </div>
                </form>
                <small id="scoreUpdateMsg" class="text-success"></small>
            </div>
        @endif
    </div>
</div>

{{-- Match Statistics module --}}
<h4 class="mb-3"><i class="bi bi-bar-chart"></i> Match Statistics</h4>
@if($match->statistic)
    @php $s = $match->statistic; @endphp
    <div class="card"><div class="card-body">
        <table class="table table-borderless mb-0">
            <tr><td>{{ $s->home_possession }}%</td><td class="text-center">Possession</td><td class="text-end">{{ $s->away_possession }}%</td></tr>
            <tr><td>{{ $s->home_shots }}</td><td class="text-center">Shots</td><td class="text-end">{{ $s->away_shots }}</td></tr>
            <tr><td>{{ $s->home_shots_on_target }}</td><td class="text-center">Shots on Target</td><td class="text-end">{{ $s->away_shots_on_target }}</td></tr>
            <tr><td>{{ $s->home_corners }}</td><td class="text-center">Corners</td><td class="text-end">{{ $s->away_corners }}</td></tr>
            <tr><td>{{ $s->home_fouls }}</td><td class="text-center">Fouls</td><td class="text-end">{{ $s->away_fouls }}</td></tr>
            <tr><td>{{ $s->home_yellow_cards }}</td><td class="text-center">Yellow Cards</td><td class="text-end">{{ $s->away_yellow_cards }}</td></tr>
            <tr><td>{{ $s->home_red_cards }}</td><td class="text-center">Red Cards</td><td class="text-end">{{ $s->away_red_cards }}</td></tr>
        </table>
    </div></div>
@else
    <p class="text-muted">Statistics for this match have not been added yet.</p>
@endif
@endsection

@section('scripts')
<script>
// Ei script AJAX diye live score update kore, page refresh chara e
const scoreForm = document.getElementById('scoreUpdateForm');
if (scoreForm) {
    scoreForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const matchId = document.getElementById('scoreCard').dataset.matchId;
        const token = document.querySelector('meta[name="csrf-token"]').content;

        fetch(`/admin/matches/${matchId}/score`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({
                home_score: document.getElementById('homeScoreInput').value,
                away_score: document.getElementById('awayScoreInput').value,
                status: document.getElementById('statusInput').value,
            }),
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('scoreDisplay').innerText = `${data.home_score} - ${data.away_score}`;
                document.getElementById('statusBadge').innerText = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                document.getElementById('scoreUpdateMsg').innerText = data.message;
            }
        })
        .catch(() => alert('There was a problem updating the score.'));
    });
}
</script>
@endsection