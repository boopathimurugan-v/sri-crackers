<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Setting;
use App\Models\OrderItem;
use App\Models\Product;
use App\Mail\OrderReceivedMail;
use App\Mail\AdminOrderNotificationMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

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
            'billing_email' => 'required|email|max:255',
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
            return $this->failure($request, 'Your cart is empty.', ['cart' => 'Your cart is empty.'], 422);
        }

        // Guard against duplicate submissions (double-click, slow response + retry, etc.):
        // if this same customer already placed an order in the last 30 seconds, don't create
        // a second one — just send them to the success page for the order that already exists.
        $recentDuplicate = Order::where('billing_email', $request->billing_email)
            ->where('billing_phone', $request->billing_phone)
            ->where('created_at', '>=', now()->subSeconds(30))
            ->latest('id')
            ->first();

        if ($recentDuplicate) {
            return $this->respondWithOrder($request, $recentDuplicate);
        }

        try {
            DB::beginTransaction();

            $subtotal = 0;
            $orderItemsData = [];

            foreach ($cart as $item) {
                // In a real scenario, you'd fetch the product by ID to ensure price hasn't been tampered with.
                // Since the Alpine cart currently only passes name, category, and price, we'll try to find the product by name.
                $product = Product::where('name', $item['name'])->first();
                $price = $product ? $product->price : $item['price'];

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

            $settings = Setting::first();
            $gstAmount = 0;
            if ($settings && $settings->gst_enabled) {
                $gstAmount = ($subtotal * $settings->gst_percentage) / 100;
            }

            $discountPercentage = $settings ? (float) $settings->overall_discount_percentage : 0;
            $discountAmount = ($subtotal * $discountPercentage) / 100;
            $totalAmount = $subtotal - $discountAmount + $gstAmount;

            $isShippingSame = $request->has('is_shipping_same') ? 1 : 0;

            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'subtotal' => $subtotal,
                'net_amount' => $subtotal,
                'discount_amount' => $discountAmount,
                'gst_amount' => $gstAmount,
                'total_amount' => $totalAmount,
                'status' => 'pending_confirmation',
                'payment_status' => 'payment_pending',

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

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating order: ' . $e->getMessage(), ['exception' => $e]);
            return $this->failure($request, 'Something went wrong while processing your order. Please try again.', ['error' => 'Something went wrong while processing your order. Please try again.'], 500);
        }

        $order->load('items');

        // Emails are queued rather than sent inline: a slow or misconfigured SMTP server
        // must never make the customer's browser sit and wait on "Place Order".
        try {
            Mail::to($order->billing_email)->queue(new OrderReceivedMail($order));
        } catch (\Exception $e) {
            Log::error('Error queueing order received email: ' . $e->getMessage(), ['exception' => $e]);
        }

        try {
            Mail::to(config('mail.admin_address'))->queue(new AdminOrderNotificationMail($order));
        } catch (\Exception $e) {
            Log::error('Error queueing admin order notification email: ' . $e->getMessage(), ['exception' => $e]);
        }

        return $this->respondWithOrder($request, $order);
    }

    public function success($order_number)
    {
        $order = Order::where('order_number', $order_number)->with('items')->firstOrFail();
        return view('checkout-success', compact('order'));
    }

    /**
     * After an order is created (or an existing recent duplicate is found), send the
     * customer on to the success page — as JSON for an AJAX submission, or a normal
     * redirect for a plain (no-JS) form fallback.
     */
    protected function respondWithOrder(Request $request, Order $order)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'redirect' => route('checkout.success', $order->order_number),
                'order_number' => $order->order_number,
            ]);
        }

        return redirect()->route('checkout.success', $order->order_number);
    }

    /**
     * Build the appropriate error response for either an AJAX/JSON checkout
     * submission or a plain (no-JS) form fallback.
     */
    protected function failure(Request $request, string $message, array $errors, int $status)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => $message,
                'errors' => $errors,
            ], $status);
        }

        return back()->withErrors($errors)->withInput();
    }
}
