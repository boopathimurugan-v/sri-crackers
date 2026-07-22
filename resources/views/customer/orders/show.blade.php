@extends('layouts.customer')

@section('title', 'Order Details')

@section('customer_content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('customer.orders.index') }}" class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-slate-800 transition shadow-sm">
        <i data-lucide="arrow-left" class="w-5 h-5"></i>
    </a>
    <h1 class="text-2xl font-bold text-slate-900">Order #{{ $order->order_number }}</h1>
</div>

<div class="flex flex-col lg:flex-row gap-8">
    <div class="w-full lg:w-2/3 space-y-6">
        
        {!! '<!-- Order Items -->' !!}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8">
            <h2 class="text-lg font-bold text-slate-900 mb-6">Order Items</h2>
            <ul class="space-y-4">
                @foreach($order->items as $item)
                    <li class="flex justify-between items-center pb-4 border-b border-slate-50 last:border-0 last:pb-0">
                        <div class="flex-1">
                            <span class="font-bold text-slate-800 block">{{ $item->item_name }}</span>
                            <span class="text-slate-500 text-sm">₹{{ number_format($item->price, 2) }} × {{ $item->quantity }}</span>
                        </div>
                        <span class="font-bold text-slate-900">₹{{ number_format($item->total, 2) }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        {!! '<!-- Address Details -->' !!}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <h3 class="font-bold text-slate-900 mb-3 flex items-center gap-2">
                    <i data-lucide="map-pin" class="w-4 h-4 text-slate-400"></i> Billing Address
                </h3>
                <div class="text-sm text-slate-600 space-y-1">
                    <p class="font-bold text-slate-800">{{ $order->billing_name }}</p>
                    <p>{{ $order->billing_phone }}</p>
                    <p class="mt-2">{{ $order->billing_address }}</p>
                    <p>{{ $order->billing_city }}, {{ $order->billing_state }} - {{ $order->billing_pincode }}</p>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <h3 class="font-bold text-slate-900 mb-3 flex items-center gap-2">
                    <i data-lucide="truck" class="w-4 h-4 text-slate-400"></i> Shipping Address
                </h3>
                <div class="text-sm text-slate-600 space-y-1">
                    @if($order->is_shipping_same)
                        <p class="italic text-slate-500 mt-2">Same as billing address</p>
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

    {!! '<!-- Order Summary Sidebar -->' !!}
    <div class="w-full lg:w-1/3 space-y-6">
        
        <div class="bg-slate-50 rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-lg font-bold text-slate-900 mb-4">Summary</h2>
            
            <div class="space-y-3 text-sm text-slate-600 mb-6">
                <div class="flex justify-between">
                    <span>Date</span>
                    <span class="font-bold text-slate-900">{{ $order->created_at->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Status</span>
                    @php
                        $colors = [
                            'pending' => 'text-amber-600',
                            'processing' => 'text-blue-600',
                            'shipped' => 'text-purple-600',
                            'delivered' => 'text-green-600',
                            'cancelled' => 'text-red-600',
                        ];
                        $color = $colors[$order->status] ?? 'text-slate-600';
                    @endphp
                    <span class="font-bold uppercase tracking-wider {{ $color }}">{{ $order->status }}</span>
                </div>
            </div>

            <div class="border-t border-slate-200 pt-4 space-y-3 text-sm text-slate-600">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span class="font-bold text-slate-900">₹{{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>GST (18%)</span>
                    <span class="font-bold text-slate-900">₹{{ number_format($order->gst_amount, 2) }}</span>
                </div>
            </div>

            <div class="border-t border-slate-200 pt-4 mt-4 flex justify-between items-center">
                <span class="font-bold text-slate-900">Total</span>
                <span class="text-2xl font-black text-red-600">₹{{ number_format($order->total_amount, 2) }}</span>
            </div>
            
            <a href="{{ route('customer.invoices.download', $order->order_number) }}" class="w-full mt-6 bg-slate-900 hover:bg-black text-white font-bold py-3 rounded-xl shadow-md transition flex items-center justify-center gap-2">
                <i data-lucide="download" class="w-5 h-5"></i> Download Invoice
            </a>
        </div>

    </div>
</div>
@endsection
