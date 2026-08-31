<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Mail\OrderConfirmationMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items');
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $order->load('items');
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'billing_name' => 'required|string|max:255',
            'billing_email' => 'required|email|max:255',
            'billing_phone' => 'required|string|max:20',
            'billing_address' => 'required|string',
            'billing_city' => 'required|string|max:255',
            'billing_state' => 'required|string|max:255',
            'billing_pincode' => 'required|string|max:10',

            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',

            'discount_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending_confirmation,confirmed,processing,completed,cancelled',
            'payment_status' => 'required|in:payment_pending,payment_confirmed',
        ]);

        $wasConfirmed = $order->payment_status === 'payment_confirmed';

        DB::beginTransaction();
        try {
            $netAmount = 0;

            foreach ($request->items as $itemInput) {
                // Scope the lookup to this order so an item id can't be used to edit another order's line.
                $item = $order->items()->where('id', $itemInput['id'])->first();
                if (!$item) {
                    continue;
                }

                $lineTotal = round($itemInput['price'] * $itemInput['quantity'], 2);
                $item->update([
                    'price' => $itemInput['price'],
                    'quantity' => $itemInput['quantity'],
                    'total' => $lineTotal,
                ]);

                $netAmount += $lineTotal;
            }

            $discountAmount = (float) $request->discount_amount;
            $gstAmount = (float) $order->gst_amount;
            $totalAmount = round($netAmount - $discountAmount + $gstAmount, 2);

            $order->update([
                'billing_name' => $request->billing_name,
                'billing_email' => $request->billing_email,
                'billing_phone' => $request->billing_phone,
                'billing_address' => $request->billing_address,
                'billing_city' => $request->billing_city,
                'billing_state' => $request->billing_state,
                'billing_pincode' => $request->billing_pincode,

                'subtotal' => $netAmount,
                'net_amount' => $netAmount,
                'discount_amount' => $discountAmount,
                'total_amount' => $totalAmount,

                'status' => $request->status,
                'payment_status' => $request->payment_status,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating order: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Something went wrong while updating the order.'])->withInput();
        }

        // First time payment is confirmed: generate the final invoice and email it to the customer.
        if (!$wasConfirmed && $request->payment_status === 'payment_confirmed') {
            $this->sendFinalInvoice($order);
        }

        return redirect()->route('admin.orders.show', $order)->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $orderNumber = $order->order_number;

        // order_items and transactions both cascade-delete at the database level.
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', "Order {$orderNumber} deleted successfully.");
    }

    protected function sendFinalInvoice(Order $order): void
    {
        try {
            if (!$order->invoice_number) {
                $lastInvoice = Order::whereNotNull('invoice_number')->latest('id')->first();
                $nextId = $lastInvoice ? (int) str_replace('INV-2026-', '', $lastInvoice->invoice_number) + 1 : 1;
                $order->invoice_number = 'INV-2026-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
                $order->save();
            }

            $order->load('items');

            $pdf = Pdf::loadView('invoices.template', compact('order'));
            $pdfData = $pdf->output();

            if (!empty($order->billing_email)) {
                Mail::to($order->billing_email)->queue(new OrderConfirmationMail($order, $pdfData));
            }
        } catch (\Exception $e) {
            Log::error('Error generating invoice PDF or sending confirmation email: ' . $e->getMessage(), ['exception' => $e]);
        }
    }
}
