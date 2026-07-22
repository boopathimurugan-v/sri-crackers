@extends('admin.layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 100vh; background-color: #f4f6f9;">
    <div class="card shadow-sm border-0" style="width: 100%; max-width: 400px; border-radius: 12px;">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <h4 class="fw-bold mb-1">Reset Password</h4>
                <p class="text-muted small">Enter your email to receive a reset link</p>
            </div>

            <!-- UI ONLY as requested -->
            <form action="#" method="POST" onsubmit="event.preventDefault(); alert('This is a UI-only representation. Password reset logic is not implemented yet.');">
                
                <div class="form-floating mb-4">
                    <input type="email" class="form-control rounded-3" id="email" name="email" placeholder="name@example.com" required autofocus>
                    <label for="email">Email address</label>
                </div>

                <button class="w-100 btn btn-primary btn-lg rounded-3 fw-semibold mb-3" type="submit">Send Reset Link</button>
                
                <div class="text-center">
                    <a href="{{ route('admin.login') }}" class="small text-decoration-none">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
