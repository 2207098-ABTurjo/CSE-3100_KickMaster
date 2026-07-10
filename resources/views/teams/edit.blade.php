@extends('layouts.app')
@section('title', 'Edit Team')

@section('content')
<h2 class="mb-4"><i class="bi bi-pencil"></i> Edit Team</h2>
<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('admin.teams.update', $team) }}">
        @csrf @method('PUT')
        @include('teams.form')
        <button type="submit" class="btn btn-primary">Update Team</button>
    </form>
</div></div>
@endsection