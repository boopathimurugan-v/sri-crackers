<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Default to last 30 days if no date is provided
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : Carbon::now()->subDays(30)->startOfDay();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : Carbon::now()->endOfDay();

        // Base order query for the date range (only successful/completed orders usually, but we'll use paid/completed statuses, or just all for simplicity if we don't have a rigid status system yet. Let's assume all orders that are not cancelled)
        $orderQuery = Order::whereBetween('created_at', [$startDate, $endDate])
                            ->where('payment_status', '!=', 'failed');

        // KPIs
        $totalRevenue = (clone $orderQuery)->sum('total_amount');
        $totalOrders = (clone $orderQuery)->count();
        $totalCustomers = (clone $orderQuery)->distinct('user_id')->count('user_id');
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Top Selling Products
        $topProducts = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
                        ->join('products', 'order_items.product_id', '=', 'products.id')
                        ->whereBetween('orders.created_at', [$startDate, $endDate])
                        ->where('orders.payment_status', '!=', 'failed')
                        ->select('products.name', 'products.sku', DB::raw('SUM(order_items.quantity) as total_quantity'), DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue'))
                        ->groupBy('products.id', 'products.name', 'products.sku')
                        ->orderByDesc('total_quantity')
                        ->limit(10)
                        ->get();

        // Recent Orders for the table
        $recentOrders = (clone $orderQuery)->with('user')->orderByDesc('created_at')->paginate(20);

        return view('admin.reports.index', compact(
            'startDate', 'endDate', 'totalRevenue', 'totalOrders', 'totalCustomers', 'avgOrderValue', 'topProducts', 'recentOrders'
        ));
    }

    public function export(Request $request)
    {
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : Carbon::now()->subDays(30)->startOfDay();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : Carbon::now()->endOfDay();

        $fileName = 'sales_report_' . $startDate->format('Y-m-d') . '_to_' . $endDate->format('Y-m-d') . '.csv';

        $orders = Order::with('user')
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->where('payment_status', '!=', 'failed')
                    ->orderByDesc('created_at')
                    ->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Order ID', 'Invoice Number', 'Date', 'Customer Name', 'Customer Email', 'Payment Method', 'Payment Status', 'Order Status', 'Total Amount');

        $callback = function() use($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($orders as $order) {
                $row['Order ID']  = $order->order_number ?? $order->id;
                $row['Invoice Number'] = $order->invoice_number ?? 'N/A';
                $row['Date']    = $order->created_at->format('Y-m-d H:i');
                $row['Customer Name']  = $order->user ? $order->user->name : 'Guest';
                $row['Customer Email'] = $order->user ? $order->user->email : 'N/A';
                $row['Payment Method']  = $order->payment_method;
                $row['Payment Status']  = $order->payment_status;
                $row['Order Status']  = $order->status;
                $row['Total Amount']  = $order->total_amount;

                fputcsv($file, array($row['Order ID'], $row['Invoice Number'], $row['Date'], $row['Customer Name'], $row['Customer Email'], $row['Payment Method'], $row['Payment Status'], $row['Order Status'], $row['Total Amount']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
