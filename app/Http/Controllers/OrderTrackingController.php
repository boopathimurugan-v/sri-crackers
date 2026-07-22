<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderTrackingController extends Controller
{
    public function index()
    {
        return view('track-order');
    }

    public function track(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
            'phone' => 'required|string'
        ]);

        $order = Order::with('items')
            ->where('order_number', $request->order_number)
            ->where('billing_phone', $request->phone)
            ->first();

        if (!$order) {
            return back()->withErrors(['error' => 'No order found with the provided details. Please check your tracking number and phone.']);
        }

        return view('track-order', compact('order'));
    }
}
