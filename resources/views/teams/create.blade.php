@extends('layouts.app')
@section('title', 'Add Team')

@section('content')
<h2 class="mb-4"><i class="bi bi-plus-lg"></i> Add New Team</h2>
<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('admin.teams.store') }}">
        @csrf
        @include('teams.form')
        <button type="submit" class="btn btn-primary">Save Team</button>
    </form>
</div></div>
@endsection