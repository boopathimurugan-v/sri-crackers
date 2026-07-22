@extends('admin.layouts.app')

@section('title', 'Admin Login')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 100vh; background-color: #f4f6f9;">
    <div class="card shadow-sm border-0" style="width: 100%; max-width: 400px; border-radius: 12px;">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <h4 class="fw-bold mb-1">Sri Crackers Admin</h4>
                <p class="text-muted small">Sign in to start your session</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger p-2 mb-4">
                    <ul class="mb-0 small ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf
                <div class="form-floating mb-3">
                    <input type="email" class="form-control rounded-3" id="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required autofocus>
                    <label for="email">Email address</label>
                </div>
                
                <div class="form-floating mb-3">
                    <input type="password" class="form-control rounded-3" id="password" name="password" placeholder="Password" required>
                    <label for="password">Password</label>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label small text-muted" for="remember">
                            Remember Me
                        </label>
                    </div>
                    <a href="{{ route('admin.password.request') }}" class="small text-decoration-none">Forgot Password?</a>
                </div>

                <button class="w-100 btn btn-primary btn-lg rounded-3 fw-semibold" type="submit">Sign in</button>
            </form>
        </div>
    </div>
</div>
@endsection
