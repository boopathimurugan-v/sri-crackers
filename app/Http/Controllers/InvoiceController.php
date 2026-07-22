<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Display the HTML version of the invoice for printing.
     */
    public function show($order_number)
    {
        $order = Order::with('items')->where('order_number', $order_number)->firstOrFail();
        
        // Ensure user is authorized to view this invoice
        if (!request()->routeIs('admin.*') && $order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to invoice.');
        }

        return view('invoices.template', compact('order'));
    }

    /**
     * Generate and download the PDF version of the invoice.
     */
    public function download($order_number)
    {
        $order = Order::with('items')->where('order_number', $order_number)->firstOrFail();
        
        // Ensure user is authorized to download this invoice
        if (!request()->routeIs('admin.*') && $order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to invoice.');
        }

        $pdf = Pdf::loadView('invoices.template', compact('order'));
        
        $filename = ($order->invoice_number ?? $order->order_number) . '.pdf';
        
        return $pdf->download($filename);
    }
}
