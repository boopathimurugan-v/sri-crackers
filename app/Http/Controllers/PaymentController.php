<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Transaction;
use App\Mail\OrderConfirmationMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function process($order_number)
    {
        $order = Order::with('upiAccount')->where('order_number', $order_number)->firstOrFail();
        
        // Find the pending transaction for this order
        $transaction = Transaction::where('order_id', $order->id)
                                  ->where('status', 'pending')
                                  ->latest()
                                  ->first();

        if (!$transaction) {
            return redirect()->route('home')->withErrors(['error' => 'No pending payment found for this order.']);
        }

        $upiAccount = $order->upiAccount;
        $upiUnavailable = ($order->upi_account_id === null || !$upiAccount || !$upiAccount->is_active);

        return view('payment.process', compact('order', 'transaction', 'upiAccount', 'upiUnavailable'));
    }

    public function callback(Request $request, $transaction_id)
    {
        $transaction = Transaction::findOrFail($transaction_id);
        $order = $transaction->order;

        $request->validate([
            'transaction_ref' => 'required|string|max:255',
            'payment_screenshot' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5000',
        ]);

        $status = $request->input('status', 'success');
        $transaction_ref = $request->input('transaction_ref');

        if ($status === 'success') {
            $screenshotPath = null;
            if ($request->hasFile('payment_screenshot')) {
                $screenshotPath = $request->file('payment_screenshot')->store('payment_screenshots', 'public');
            }

            $transaction->update([
                'status' => 'success',
                'transaction_ref' => $transaction_ref,
                'gateway_response' => $request->except(['payment_screenshot']),
            ]);

            // Generate Invoice Number if not exists
            if (!$order->invoice_number) {
                $lastInvoice = Order::whereNotNull('invoice_number')->latest('id')->first();
                $nextId = $lastInvoice ? (int)str_replace('INV-2026-', '', $lastInvoice->invoice_number) + 1 : 1;
                $invoiceNumber = 'INV-2026-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
            } else {
                $invoiceNumber = $order->invoice_number;
            }

            // Mark Order Status as "confirmed", payment status as "paid"
            $order->update([
                'status' => 'confirmed',
                'payment_status' => 'paid',
                'invoice_number' => $invoiceNumber,
                'payment_screenshot' => $screenshotPath ?? $order->payment_screenshot,
            ]);

            // Load relationships for Invoice & Email
            $order->load(['items', 'upiAccount']);

            // Automatically Generate PDF Invoice
            try {
                $pdf = Pdf::loadView('invoices.template', compact('order'));
                $pdfData = $pdf->output();

                // Automatically Send Order Confirmation Email to Customer
                if (!empty($order->billing_email)) {
                    Mail::to($order->billing_email)->send(new OrderConfirmationMail($order, $pdfData));
                }
            } catch (\Exception $e) {
                Log::error('Error generating invoice PDF or sending email: ' . $e->getMessage());
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
