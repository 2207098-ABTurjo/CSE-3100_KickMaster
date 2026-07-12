@extends('layouts.app')
@section('title', 'Add Player')

@section('content')
<h2 class="mb-4"><i class="bi bi-plus-lg"></i> Add New Player</h2>
<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('admin.players.store') }}">
        @csrf
        @include('players.form')
        <button type="submit" class="btn btn-primary">Save Player</button>
    </form>
</div></div>
@endsection