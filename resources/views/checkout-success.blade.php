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
                <h1 class="text-4xl font-extrabold relative z-10">Order Placed Successfully!</h1>
                <p class="text-green-100 mt-2 relative z-10">Thank you for choosing Sri Crackers.</p>
            </div>

            <div class="p-8 sm:p-12">
                <div class="mb-8 border-b border-slate-100 pb-8">
                    <p class="text-sm text-slate-500 uppercase tracking-wider font-bold mb-2">Your Tracking ID</p>
                    <div class="inline-block bg-slate-100 border border-slate-200 text-slate-900 text-2xl font-black px-6 py-3 rounded-xl tracking-widest user-select-all">
                        {{ $order->order_number }}
                    </div>
                    <p class="text-sm text-slate-500 mt-4 max-w-md mx-auto">
                        Please save this tracking ID. You can use it along with your phone number ({{ $order->billing_phone }}) to track your order status.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
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
        localStorage.removeItem('cart');
    });
</script>
@endsection
