@extends('layouts.app')
@section('title', 'Fixtures')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-calendar-event"></i> Fixtures</h2>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.fixtures.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add Fixture</a>
    @endif
</div>

<form method="GET" class="row g-2 mb-4">
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">All Status</option>
            @foreach(['scheduled','completed','cancelled'] as $st)
                <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <input type="date" name="date" class="form-control" value="{{ request('date') }}">
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-outline-secondary w-100"><i class="bi bi-funnel"></i> Filter</button>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead><tr><th>Date</th><th>Home</th><th>Away</th><th>Venue</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        @forelse($fixtures as $fixture)
            <tr>
                <td>{{ $fixture->match_date->format('d M Y, h:i A') }}</td>
                <td>{{ $fixture->homeTeam->name }}</td>
                <td>{{ $fixture->awayTeam->name }}</td>
                <td>{{ $fixture->venue }}</td>
                <td><span class="badge bg-{{ $fixture->status == 'completed' ? 'success' : ($fixture->status == 'cancelled' ? 'danger' : 'info') }}">{{ ucfirst($fixture->status) }}</span></td>
                <td>
                    <a href="{{ route('fixtures.show', $fixture) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.fixtures.edit', $fixture) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.fixtures.destroy', $fixture) }}" method="POST" class="d-inline delete-form">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center text-muted">No fixtures found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $fixtures->links() }}</div>
@endsection