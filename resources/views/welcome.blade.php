@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="hero-section text-center text-white rounded-4 p-5 mb-5">
    <h1 class="display-4 fw-bold"><i class="bi bi-trophy-fill"></i> Welcome to KickMaster</h1>
    <p class="lead">All your football team, player and match updates in one place</p>
    <a href="{{ route('login') }}" class="btn btn-warning btn-lg me-2">Login</a>
    <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">Register</a>
</div>
@endsection