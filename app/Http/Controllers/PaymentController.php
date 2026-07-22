<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Transaction;

class PaymentController extends Controller
{
    public function process($order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();
        
        // Find the pending transaction for this order
        $transaction = Transaction::where('order_id', $order->id)
                                  ->where('status', 'pending')
                                  ->latest()
                                  ->first();

        if (!$transaction) {
            return redirect()->route('home')->withErrors(['error' => 'No pending payment found for this order.']);
        }

        if ($transaction->payment_method === 'cod') {
            // For COD, we mark it success automatically
            $transaction->update(['status' => 'success']);
            
            if (!$order->invoice_number) {
                $lastInvoice = Order::whereNotNull('invoice_number')->latest('id')->first();
                $nextId = $lastInvoice ? (int)str_replace('INV-2026-', '', $lastInvoice->invoice_number) + 1 : 1;
                $invoiceNumber = 'INV-2026-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
                
                $order->update([
                    'status' => 'processing',
                    'invoice_number' => $invoiceNumber
                ]);
            } else {
                $order->update(['status' => 'processing']);
            }
            
            return redirect()->route('checkout.success', $order->order_number);
        }

        // Render the "Ready" Scaffold for Gateway
        return view('payment.process', compact('order', 'transaction'));
    }

    public function callback(Request $request, $transaction_id)
    {
        $transaction = Transaction::findOrFail($transaction_id);
        $order = $transaction->order;

        // In a real scenario, you would verify signatures here (e.g., Razorpay signature)
        // Since this is a scaffold/simulation, we accept 'success' or 'failed' from the request
        
        $status = $request->input('status'); // 'success' or 'failed'
        $transaction_ref = $request->input('transaction_ref') ?? 'SIM-' . strtoupper(uniqid());

        if ($status === 'success') {
            $transaction->update([
                'status' => 'success',
                'transaction_ref' => $transaction_ref,
                'gateway_response' => $request->all()
            ]);
            
            // Generate invoice number if not exists
            if (!$order->invoice_number) {
                $lastInvoice = Order::whereNotNull('invoice_number')->latest('id')->first();
                $nextId = $lastInvoice ? (int)str_replace('INV-2026-', '', $lastInvoice->invoice_number) + 1 : 1;
                $invoiceNumber = 'INV-2026-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
                
                $order->update([
                    'status' => 'processing',
                    'invoice_number' => $invoiceNumber
                ]);
            } else {
                $order->update(['status' => 'processing']);
            }
            
            return redirect()->route('checkout.success', $order->order_number);
        } else {
            $transaction->update([
                'status' => 'failed',
                'gateway_response' => $request->all()
            ]);
            
            return redirect()->route('checkout')->withErrors(['error' => 'Payment failed. Please try again.']);
        }
    }
}
