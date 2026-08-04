<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index() { return view('home'); }
    public function show($order_number) { return view('home'); }
}
