<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function profile()
    {
        return view('home');
    }

    public function updateProfile()
    {
        return redirect()->back();
    }

    public function password()
    {
        return view('home');
    }

    public function updatePassword()
    {
        return redirect()->back();
    }
}
