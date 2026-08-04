<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

class WishlistController extends Controller
{
    public function index() { return view('home'); }
    public function store() { return redirect()->back(); }
    public function destroy($id) { return redirect()->back(); }
}
