@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="hero-section text-center text-white rounded-4 p-5 mb-5">
    <h1 class="display-4 fw-bold"><i class="bi bi-trophy-fill"></i> Welcome to KickMaster</h1>
    <p class="lead">All your football team, player and match updates in one place</p>
    <a href="{{ route('login') }}" class="btn btn-warning btn-lg me-2">Login</a>
    <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">Register</a>
</div>

<h3 class="mb-3"><i class="bi bi-calendar-event"></i> Upcoming Fixtures</h3>
<div class="row g-4">
    @forelse($fixtures as $fixture)
        <div class="col-md-4">
            <div class="card fixture-card h-100">
                <div class="card-body text-center">
                    <p class="text-muted small mb-2">{{ $fixture->match_date->format('d M Y, h:i A') }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">{{ $fixture->homeTeam->short_name }}</span>
                        <span class="badge bg-secondary">VS</span>
                        <span class="fw-bold">{{ $fixture->awayTeam->short_name }}</span>
                    </div>
                    <p class="text-muted small mt-2 mb-0"><i class="bi bi-geo-alt"></i> {{ $fixture->venue }}</p>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">No upcoming fixtures right now.</p>
    @endforelse
</div>
@endsection