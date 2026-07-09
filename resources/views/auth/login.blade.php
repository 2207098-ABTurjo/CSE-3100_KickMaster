@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card auth-card">
            <div class="card-body p-4">
                <h3 class="text-center mb-4"><i class="bi bi-box-arrow-in-right"></i> Login</h3>

                {{-- Validation error dekhano hocche --}}
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Remember Me</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
                <p class="text-center mt-3 mb-0">Don't have an account? <a href="{{ route('register') }}">Register</a></p>
                <hr>
                <p class="text-muted small text-center mb-0">Demo Admin: admin@kickmaster.com / password</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Ei script simple client side form validation kore submit korar age
document.getElementById('loginForm').addEventListener('submit', function (e) {
    const email = this.email.value.trim();
    const password = this.password.value.trim();
    if (!email || !password) {
        e.preventDefault();
        alert('Email ar password field khali rakha jabe na.');
    }
});
</script>
@endsection