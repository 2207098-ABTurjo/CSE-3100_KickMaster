@extends('layouts.app')
@section('title', 'Edit Player')

@section('content')
<h2 class="mb-4"><i class="bi bi-pencil"></i> Edit Player</h2>
<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('admin.players.update', $player) }}">
        @csrf @method('PUT')
        @include('players.form')
        <button type="submit" class="btn btn-primary">Update Player</button>
    </form>
</div></div>
@endsection