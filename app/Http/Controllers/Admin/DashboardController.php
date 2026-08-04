<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\UpiAccount;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();
        $todayOrders = Order::whereDate('created_at', Carbon::today())->latest()->get();

        $upiAccounts = UpiAccount::withCount('orders')
            ->orderBy('display_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $totalTodayCollection = UpiAccount::sum('current_collection');

        return view('admin.dashboard.index', compact(
            'totalProducts',
            'totalCategories',
            'totalOrders',
            'todayOrders',
            'upiAccounts',
            'totalTodayCollection'
        ));
    }
}