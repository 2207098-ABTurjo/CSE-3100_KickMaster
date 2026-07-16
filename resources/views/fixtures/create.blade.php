@extends('layouts.app')
@section('title', 'Add Fixture')

@section('content')
<h2 class="mb-4"><i class="bi bi-plus-lg"></i> Add New Fixture</h2>
<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('admin.fixtures.store') }}">
        @csrf
        @include('fixtures.form')
        <button type="submit" class="btn btn-primary">Save Fixture</button>
    </form>
</div></div>
@endsection