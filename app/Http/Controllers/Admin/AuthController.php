<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    /**
     * Handle the admin login attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $attemptCredentials = [
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'is_admin' => 1
        ];

        if (Auth::attempt($attemptCredentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Show the forgot password form (UI only).
     */
    public function showForgotPasswordForm()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        // For now, we'll just return the login view with a message, 
        // or a dedicated forgot password view if created.
        // As per requirements: "Forgot Password (UI only)"
        // Let's create a dedicated view for it or handle it in login.
        // The requirements didn't ask to create a specific forgot password view,
        // but it asked for "Forgot Password (UI only)".
        // I will just return the login view with a session flash for simplicity,
        // or I can create admin/auth/forgot-password.blade.php. 
        // Let's create it.
        return view('admin.auth.forgot-password');
    }

    /**
     * Log the admin out.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
