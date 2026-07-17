@extends('layouts.app')
@section('title', 'Add Match')

@section('content')
<h2 class="mb-4"><i class="bi bi-plus-lg"></i> Add New Match</h2>
<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('admin.matches.store') }}">
        @csrf
        @include('matches.form')
        <button type="submit" class="btn btn-primary">Save Match</button>
    </form>
</div></div>
@endsection