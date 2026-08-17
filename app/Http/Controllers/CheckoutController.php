<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Setting;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\PricingService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout');
    }

    public function store(Request $request)
    {
        $request->validate([
            'billing_name'     => 'required|string|max:255',
            'billing_phone'    => 'required|string|max:20',
            'billing_email'    => 'nullable|email|max:255',
            'billing_address'  => 'required|string',
            'billing_city'     => 'required|string|max:255',
            'billing_state'    => 'required|string|max:255',
            'billing_pincode'  => 'required|string|max:10',

            'shipping_name'    => 'required_if:is_shipping_same,0|nullable|string|max:255',
            'shipping_phone'   => 'required_if:is_shipping_same,0|nullable|string|max:20',
            'shipping_address' => 'required_if:is_shipping_same,0|nullable|string',
            'shipping_city'    => 'required_if:is_shipping_same,0|nullable|string|max:255',
            'shipping_state'   => 'required_if:is_shipping_same,0|nullable|string|max:255',
            'shipping_pincode' => 'required_if:is_shipping_same,0|nullable|string|max:10',

            'cart_data'        => 'required|string',
        ]);

        $cart = json_decode($request->cart_data, true);
        if (empty($cart)) {
            return back()->withErrors(['cart' => 'Your cart is empty.']);
        }

        try {
            DB::beginTransaction();

            $pricingService = new PricingService();
            $orderItemsData = [];
            $lineItems      = []; // For PricingService

            foreach ($cart as $item) {
                // Always fetch the authoritative price from the DB to prevent price tampering
                $product = Product::where('name', $item['name'])->first();
                $price   = $product ? (float)$product->price : (float)($item['price'] ?? 0);

                $lineItems[]      = ['price' => $price, 'quantity' => (int)$item['quantity']];
                $orderItemsData[] = [
                    'product_id' => $product ? $product->id : null,
                    'item_name'  => $item['name'],
                    'price'      => $price,
                    'quantity'   => (int)$item['quantity'],
                    'total'      => round($price * (int)$item['quantity'], 2),
                ];
            }

            // Calculate totals via PricingService (single source of truth)
            $totals = $pricingService->calculateCartTotals($lineItems);

            $isShippingSame = $request->has('is_shipping_same') ? 1 : 0;

            $order = Order::create([
                'order_number'    => 'ORD-' . strtoupper(Str::random(10)),

                // Legacy subtotal = net_amount (for any code that still reads subtotal)
                'subtotal'        => $totals['net_amount'],
                'gst_amount'      => 0, // GST replaced by global discount system
                'net_amount'      => $totals['net_amount'],
                'discount_amount' => $totals['discount_amount'],
                'total_amount'    => $totals['total_amount'],

                'status' => 'pending',

                'billing_name'    => $request->billing_name,
                'billing_phone'   => $request->billing_phone,
                'billing_email'   => $request->billing_email,
                'billing_address' => $request->billing_address,
                'billing_city'    => $request->billing_city,
                'billing_state'   => $request->billing_state,
                'billing_pincode' => $request->billing_pincode,

                'is_shipping_same' => $isShippingSame,
                'shipping_name'    => $isShippingSame ? null : $request->shipping_name,
                'shipping_phone'   => $isShippingSame ? null : $request->shipping_phone,
                'shipping_address' => $isShippingSame ? null : $request->shipping_address,
                'shipping_city'    => $isShippingSame ? null : $request->shipping_city,
                'shipping_state'   => $isShippingSame ? null : $request->shipping_state,
                'shipping_pincode' => $isShippingSame ? null : $request->shipping_pincode,
            ]);

            foreach ($orderItemsData as $itemData) {
                $order->items()->create($itemData);
            }

            // Allocate UPI account via Smart Rotation Service
            $upiService = new \App\Services\UpiRotationService();
            $upiService->assignUpiToOrder($order);

            // Create Pending Transaction — amount = final discounted total
            \App\Models\Transaction::create([
                'order_id'       => $order->id,
                'payment_method' => 'upi',
                'amount'         => $totals['total_amount'],
                'status'         => 'pending',
            ]);

            DB::commit();

            return redirect()->route('payment.process', $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Something went wrong while processing your order. Please try again.']);
        }
    }

    public function success($order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();
        return view('checkout-success', compact('order'));
    }
}
