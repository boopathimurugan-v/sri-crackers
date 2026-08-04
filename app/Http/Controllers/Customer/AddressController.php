<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    public function index() { return view('home'); }
    public function create() { return view('home'); }
    public function store() { return redirect()->back(); }
    public function edit() { return view('home'); }
    public function update() { return redirect()->back(); }
    public function destroy() { return redirect()->back(); }
}
