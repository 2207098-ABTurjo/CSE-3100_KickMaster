@extends('layouts.app')
@section('title', 'Manage Users')

@section('content')
<h2 class="mb-4"><i class="bi bi-person-gear"></i> Manage Users</h2>

<form method="GET" class="mb-3">
    <div class="input-group" style="max-width:400px;">
        <input type="text" name="search" class="form-control" placeholder="Search by name/email..." value="{{ request('search') }}">
        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Joined</th><th>Action</th></tr></thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td><span class="badge bg-{{ $user->isAdmin() ? 'warning text-dark' : 'secondary' }}">{{ ucfirst($user->role) }}</span></td>
                <td>{{ $user->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                    @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline delete-form">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $users->links() }}</div>
@endsection