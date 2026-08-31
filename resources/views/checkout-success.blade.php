@extends('layouts.store')

@section('title', 'Order Successful')

@section('content')
<div class="bg-slate-50 py-16 min-h-[60vh] flex items-center justify-center">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden text-center">
            
            <div class="bg-green-500 py-12 px-8 flex flex-col items-center justify-center text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCI+PHBhdGggZD0iTTExLjUgMWMwIC45LjcgbSAxLjUgMS41LjcgMi41bDEuNSAxLjVWMThsLTEuNSAxLjUtMS41Ljc1LTEuNS43NS0uNzUgMS41TDggMjNsLTEuNS0uNzUtMS41LS43NVYyMWwtMS41LS43NWMwLS45LS43LTItMS41LTEuNWwtMS41LTEuNXYtMS41bDcuNS0uNzVWNmgxLjVWNGwxLjUtMS41eiIgZmlsbD0iI2ZmZmZmZjIwIi8+PC9zdmc+')] opacity-20"></div>
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mb-6 relative z-10 shadow-lg">
                    <i data-lucide="check" class="w-10 h-10 text-green-500"></i>
                </div>
                <h1 class="text-4xl font-extrabold relative z-10">Order Received Successfully!</h1>
                <p class="text-green-100 mt-2 relative z-10">Thank you for choosing SRI CRACKERS.</p>
            </div>

            <div class="p-8 sm:p-12">
                <div class="mb-8 border-b border-slate-100 pb-8">
                    <p class="text-slate-600 max-w-md mx-auto mb-6">
                        Your order has been received. Our team will contact you shortly to confirm the order and payment details.
                    </p>

                    <p class="text-sm text-slate-500 uppercase tracking-wider font-bold mb-2">Your Order Number</p>
                    <div class="inline-block bg-slate-100 border border-slate-200 text-slate-900 text-2xl font-black px-6 py-3 rounded-xl tracking-widest user-select-all">
                        {{ $order->order_number }}
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-md mx-auto mt-8 text-left">
                        <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Customer Name</p>
                            <p class="font-bold text-slate-900">{{ $order->billing_name }}</p>
                        </div>
                        <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Phone Number</p>
                            <p class="font-bold text-slate-900">{{ $order->billing_phone }}</p>
                        </div>
                        <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 sm:col-span-2">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Order Amount</p>
                            <p class="font-black text-2xl text-amber-600">₹{{ number_format($order->total_amount, 2) }}</p>
                        </div>
                    </div>

                    <div class="bg-amber-50 border border-amber-200 text-amber-800 text-sm font-bold rounded-xl p-4 max-w-md mx-auto mt-6">
                        Payment details will be shared by our SRI CRACKERS team after order confirmation. Please wait for our call/message.
                    </div>

                    <p class="text-sm text-slate-500 mt-6 max-w-md mx-auto">
                        Please save this order number. You can use it along with your phone number to track your order status.
                    </p>
                </div>

                <div class="mb-8 text-left max-w-md mx-auto">
                    <p class="text-sm text-slate-500 uppercase tracking-wider font-bold mb-3">Order Details</p>
                    <div class="bg-slate-50 border border-slate-100 rounded-xl divide-y divide-slate-200">
                        @foreach($order->items as $item)
                            <div class="flex justify-between items-center p-3 text-sm">
                                <div>
                                    <span class="font-bold text-slate-800">{{ $item->item_name }}</span>
                                    <span class="text-slate-500"> × {{ $item->quantity }}</span>
                                </div>
                                <span class="font-bold text-slate-900">₹{{ number_format($item->total, 2) }}</span>
                            </div>
                        @endforeach
                        <div class="flex justify-between items-center p-3 text-sm text-slate-600">
                            <span>Net Amount</span>
                            <span class="font-bold text-slate-900">₹{{ number_format($order->net_amount ?? $order->subtotal, 2) }}</span>
                        </div>
                        @if($order->discount_amount > 0)
                            <div class="flex justify-between items-center p-3 text-sm text-green-700">
                                <span>Discount</span>
                                <span class="font-bold">-₹{{ number_format($order->discount_amount, 2) }}</span>
                            </div>
                        @endif
                        @if($order->gst_amount > 0)
                            <div class="flex justify-between items-center p-3 text-sm text-slate-600">
                                <span>GST</span>
                                <span class="font-bold text-slate-900">₹{{ number_format($order->gst_amount, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between items-center p-3 text-base font-bold text-slate-900">
                            <span>Total Amount</span>
                            <span class="text-amber-600">₹{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('invoices.public-download', $order->order_number) }}" class="bg-slate-900 hover:bg-black text-white font-bold px-8 py-3.5 rounded-xl shadow-md transition">
                        Download Invoice
                    </a>
                    <a href="{{ route('track-order') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold px-8 py-3.5 rounded-xl shadow-sm transition">
                        Track Order Now
                    </a>
                    <a href="{{ route('home') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-3.5 rounded-xl shadow-md transition">
                        Continue Shopping
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
    // Clear the cart on successful checkout
    document.addEventListener('alpine:init', () => {
        // Alpine data is in layout, we can access localStorage directly to clear it
        localStorage.removeItem('cracker_cart');
    });
</script>
@endsection
