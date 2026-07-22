<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
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
            'billing_name' => 'required|string|max:255',
            'billing_phone' => 'required|string|max:20',
            'billing_email' => 'nullable|email|max:255',
            'billing_address' => 'required|string',
            'billing_city' => 'required|string|max:255',
            'billing_state' => 'required|string|max:255',
            'billing_pincode' => 'required|string|max:10',
            
            'shipping_name' => 'required_if:is_shipping_same,0|nullable|string|max:255',
            'shipping_phone' => 'required_if:is_shipping_same,0|nullable|string|max:20',
            'shipping_address' => 'required_if:is_shipping_same,0|nullable|string',
            'shipping_city' => 'required_if:is_shipping_same,0|nullable|string|max:255',
            'shipping_state' => 'required_if:is_shipping_same,0|nullable|string|max:255',
            'shipping_pincode' => 'required_if:is_shipping_same,0|nullable|string|max:10',
            
            'cart_data' => 'required|string'
        ]);

        $cart = json_decode($request->cart_data, true);
        if (empty($cart)) {
            return back()->withErrors(['cart' => 'Your cart is empty.']);
        }

        try {
            DB::beginTransaction();

            $subtotal = 0;
            $orderItemsData = [];

            foreach ($cart as $item) {
                // In a real scenario, you'd fetch the product by ID to ensure price hasn't been tampered with.
                // Since the Alpine cart currently only passes name, category, and price, we'll try to find the product by name.
                $product = Product::where('name', $item['name'])->first();
                $price = $product ? $product->offer_price : $item['price'];
                
                $itemTotal = $price * $item['quantity'];
                $subtotal += $itemTotal;

                $orderItemsData[] = [
                    'product_id' => $product ? $product->id : null,
                    'item_name' => $item['name'],
                    'price' => $price,
                    'quantity' => $item['quantity'],
                    'total' => $itemTotal
                ];
            }

            // Assume GST is 18%
            $gstAmount = $subtotal * 0.18;
            $totalAmount = $subtotal + $gstAmount;

            $isShippingSame = $request->has('is_shipping_same') ? 1 : 0;

            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'subtotal' => $subtotal,
                'gst_amount' => $gstAmount,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                
                'billing_name' => $request->billing_name,
                'billing_phone' => $request->billing_phone,
                'billing_email' => $request->billing_email,
                'billing_address' => $request->billing_address,
                'billing_city' => $request->billing_city,
                'billing_state' => $request->billing_state,
                'billing_pincode' => $request->billing_pincode,
                
                'is_shipping_same' => $isShippingSame,
                'shipping_name' => $isShippingSame ? null : $request->shipping_name,
                'shipping_phone' => $isShippingSame ? null : $request->shipping_phone,
                'shipping_address' => $isShippingSame ? null : $request->shipping_address,
                'shipping_city' => $isShippingSame ? null : $request->shipping_city,
                'shipping_state' => $isShippingSame ? null : $request->shipping_state,
                'shipping_pincode' => $isShippingSame ? null : $request->shipping_pincode,
            ]);

            foreach ($orderItemsData as $itemData) {
                $order->items()->create($itemData);
            }

            // Create Pending Transaction
            $paymentMethod = $request->input('payment_method', 'razorpay');
            \App\Models\Transaction::create([
                'order_id' => $order->id,
                'payment_method' => $paymentMethod,
                'amount' => $totalAmount,
                'status' => 'pending',
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
