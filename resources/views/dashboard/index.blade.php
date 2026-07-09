@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h2 class="mb-4"><i class="bi bi-speedometer2"></i> Dashboard</h2>

<div class="card">
    <div class="card-body">
        <p class="mb-0">Welcome to KickMaster, {{ auth()->user()->name }}!</p>
    </div>
</div>
@endsection