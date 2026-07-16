@extends('layouts.app')
@section('title', 'Edit Fixture')

@section('content')
<h2 class="mb-4"><i class="bi bi-pencil"></i> Edit Fixture</h2>
<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('admin.fixtures.update', $fixture) }}">
        @csrf @method('PUT')
        @include('fixtures.form')
        <button type="submit" class="btn btn-primary">Update Fixture</button>
    </form>
</div></div>
@endsection