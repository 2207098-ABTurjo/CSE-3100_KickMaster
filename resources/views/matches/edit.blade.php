@extends('layouts.app')
@section('title', 'Edit Match')

@section('content')
<h2 class="mb-4"><i class="bi bi-pencil"></i> Edit Match</h2>
<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('admin.matches.update', $match) }}">
        @csrf @method('PUT')
        @include('matches.form')
        <button type="submit" class="btn btn-primary">Update Match</button>
    </form>
</div></div>
@endsection