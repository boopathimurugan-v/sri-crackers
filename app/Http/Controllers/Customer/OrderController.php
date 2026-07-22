<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);
        return view('customer.orders.index', compact('orders'));
    }

    public function show($order_number)
    {
        $order = auth()->user()->orders()->where('order_number', $order_number)->with('items')->firstOrFail();
        return view('customer.orders.show', compact('order'));
    }

    public function invoice($order_number)
    {
        $order = auth()->user()->orders()->where('order_number', $order_number)->with('items')->firstOrFail();
        return view('customer.orders.invoice', compact('order'));
    }
}
