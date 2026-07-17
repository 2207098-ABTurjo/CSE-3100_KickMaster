<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KickMaster') - Football Management System</title>

    {{-- Bootstrap CDN link, offline e kaj korar jonno vite build o ache --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    {{-- Amader nijeder custom CSS file --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&family=Inter:wght@400;500;600&family=Roboto+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

@auth
    {{-- Top navbar - logged in user er jonno --}}
    <nav class="navbar navbar-expand-lg navbar-dark kickmaster-navbar sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                <i class="bi bi-trophy-fill"></i> KickMaster
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <span class="nav-link">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                            @if(auth()->user()->isAdmin())
                                <span class="badge bg-warning text-dark">Admin</span>
                            @endif
                        </span>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm ms-2">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="d-flex">
        {{-- Sidebar menu --}}
        <nav class="kickmaster-sidebar d-none d-md-block">
            <div class="list-group list-group-flush">
                <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('teams.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('teams.*') ? 'active' : '' }}">
                    <i class="bi bi-shield"></i> Teams
                </a>
                <a href="{{ route('players.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('players.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Players
                </a>
                <a href="{{ route('fixtures.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('fixtures.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-event"></i> Fixtures
                </a>
                <a href="{{ route('matches.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('matches.*') ? 'active' : '' }}">
                    <i class="bi bi-broadcast"></i> Matches / Live Score
                </a>
            </div>
        </nav>

        <main class="flex-grow-1 p-4 kickmaster-main">
            {{-- Success/error flash message dekhano hocche --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
@else
    {{-- Guest navbar - login/register korar age --}}
    <nav class="navbar navbar-expand-lg navbar-dark kickmaster-navbar">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}"><i class="bi bi-trophy-fill"></i> KickMaster</a>
            <div class="ms-auto">
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-warning btn-sm">Register</a>
            </div>
        </div>
    </nav>
    <main class="container my-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </main>
@endauth

<footer class="text-center py-3 kickmaster-footer">
    <small>&copy; {{ date('Y') }} KickMaster - Web Programming Lab Project</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')
</body>
</html>