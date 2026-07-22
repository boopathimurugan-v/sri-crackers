@extends('layouts.store')

@section('title', 'Track Order')

@section('content')
<div class="bg-amber-50/50 py-8 border-b border-amber-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-2">Track Your Order</h1>
        <p class="text-slate-600">Enter your tracking ID and phone number to see your order status.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <div class="max-w-3xl mx-auto">
        
        {!! '<!-- Tracking Form -->' !!}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8 mb-12">
            <form action="{{ route('track-order.post') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Tracking ID</label>
                        <input type="text" name="order_number" value="{{ request('order_number') }}" placeholder="e.g., ORD-ABC123XYZ" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition font-mono uppercase">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Billing Phone Number</label>
                        <input type="text" name="phone" value="{{ request('phone') }}" placeholder="e.g., 9876543210" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                    </div>
                    <div class="md:col-span-2">
                        <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white font-bold py-3.5 rounded-xl shadow-md transition flex items-center justify-center gap-2">
                            <i data-lucide="search" class="w-5 h-5"></i> Find Order
                        </button>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="mt-6 text-sm text-red-600 bg-red-50 p-4 rounded-xl border border-red-100 flex items-start gap-2">
                        <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif
            </form>
        </div>

        {!! '<!-- Order Details Result -->' !!}
        @if(isset($order))
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="bg-slate-50 border-b border-slate-100 p-6 sm:p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h2 class="text-2xl font-extrabold text-slate-900 font-mono">{{ $order->order_number }}</h2>
                        <p class="text-sm text-slate-500 mt-1">Placed on {{ $order->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                    <div>
                        @php
                            $statusColors = [
                                'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                                'processing' => 'bg-blue-100 text-blue-800 border-blue-200',
                                'shipped' => 'bg-purple-100 text-purple-800 border-purple-200',
                                'delivered' => 'bg-green-100 text-green-800 border-green-200',
                                'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                            ];
                            $colorClass = $statusColors[$order->status] ?? 'bg-slate-100 text-slate-800 border-slate-200';
                        @endphp
                        <span class="px-4 py-1.5 rounded-full border text-sm font-bold uppercase tracking-wider {{ $colorClass }}">
                            {{ $order->status }}
                        </span>
                    </div>
                </div>

                <div class="p-6 sm:p-8">
                    <h3 class="font-bold text-slate-900 mb-4 border-b border-slate-100 pb-2">Order Items</h3>
                    <ul class="space-y-4 mb-8">
                        @foreach($order->items as $item)
                            <li class="flex justify-between items-center text-sm">
                                <div class="flex-1">
                                    <span class="font-bold text-slate-800">{{ $item->item_name }}</span>
                                    <span class="text-slate-500 ml-2">x {{ $item->quantity }}</span>
                                </div>
                                <span class="font-bold text-slate-900">₹{{ number_format($item->total, 2) }}</span>
                            </li>
                        @endforeach
                    </ul>
                    
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 space-y-2 text-sm text-slate-600 mb-8">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-bold text-slate-900">₹{{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>GST (18%)</span>
                            <span class="font-bold text-slate-900">₹{{ number_format($order->gst_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between pt-2 border-t border-slate-200 text-base">
                            <span class="font-bold text-slate-900">Total</span>
                            <span class="font-black text-red-600">₹{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="font-bold text-slate-900 mb-2 border-b border-slate-100 pb-2">Billing Address</h3>
                            <div class="text-sm text-slate-600">
                                <p class="font-bold text-slate-800">{{ $order->billing_name }}</p>
                                <p>{{ $order->billing_phone }}</p>
                                <p>{{ $order->billing_email }}</p>
                                <p class="mt-2">{{ $order->billing_address }}</p>
                                <p>{{ $order->billing_city }}, {{ $order->billing_state }} - {{ $order->billing_pincode }}</p>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 mb-2 border-b border-slate-100 pb-2">Shipping Address</h3>
                            <div class="text-sm text-slate-600">
                                @if($order->is_shipping_same)
                                    <p class="italic text-slate-500">Same as Billing Address</p>
                                @else
                                    <p class="font-bold text-slate-800">{{ $order->shipping_name }}</p>
                                    <p>{{ $order->shipping_phone }}</p>
                                    <p class="mt-2">{{ $order->shipping_address }}</p>
                                    <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_pincode }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>

</div>
@endsection
