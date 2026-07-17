@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h2 class="mb-4"><i class="bi bi-speedometer2"></i> Dashboard</h2>

{{-- Summary card gula ekhane dekhano hocche --}}
<div class="row g-4 mb-4">
    <div class="col-md-4 col-lg-2">
        <div class="card stat-card text-white bg-primary">
            <div class="card-body">
                <i class="bi bi-shield fs-2"></i>
                <h3>{{ $totalTeams }}</h3>
                <p class="mb-0">Total Teams</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="card stat-card text-white bg-success">
            <div class="card-body">
                <i class="bi bi-people fs-2"></i>
                <h3>{{ $totalPlayers }}</h3>
                <p class="mb-0">Total Players</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="card stat-card text-white bg-info">
            <div class="card-body">
                <i class="bi bi-broadcast fs-2"></i>
                <h3>{{ $totalMatches }}</h3>
                <p class="mb-0">Total Matches</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="card stat-card text-white bg-warning">
            <div class="card-body">
                <i class="bi bi-clock-history fs-2"></i>
                <h3>{{ $upcomingMatches }}</h3>
                <p class="mb-0">Upcoming</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="card stat-card text-white bg-secondary">
            <div class="card-body">
                <i class="bi bi-check-circle fs-2"></i>
                <h3>{{ $completedMatches }}</h3>
                <p class="mb-0">Completed</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header fw-bold"><i class="bi bi-calendar-event"></i> Latest Fixtures</div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Home Team</th>
                    <th>Away Team</th>
                    <th>Venue</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestFixtures as $fixture)
                    <tr>
                        <td>{{ $fixture->match_date->format('d M Y, h:i A') }}</td>
                        <td>{{ $fixture->homeTeam->name }}</td>
                        <td>{{ $fixture->awayTeam->name }}</td>
                        <td>{{ $fixture->venue }}</td>
                        <td><span class="badge bg-info">{{ ucfirst($fixture->status) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">No fixtures found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection