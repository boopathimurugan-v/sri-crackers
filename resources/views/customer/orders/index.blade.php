@extends('layouts.customer')

@section('title', 'My Orders')

@section('customer_content')
<h1 class="text-2xl font-bold text-slate-900 mb-6">My Orders</h1>

@if($orders->count() > 0)
    <div class="space-y-6">
        @foreach($orders as $order)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="bg-slate-50 border-b border-slate-100 px-6 py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <span class="font-mono font-bold text-slate-900">{{ $order->order_number }}</span>
                            @php
                                $colors = [
                                    'pending' => 'bg-amber-100 text-amber-800',
                                    'processing' => 'bg-blue-100 text-blue-800',
                                    'shipped' => 'bg-purple-100 text-purple-800',
                                    'delivered' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                                $color = $colors[$order->status] ?? 'bg-slate-100 text-slate-800';
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $color }}">
                                {{ $order->status }}
                            </span>
                        </div>
                        <p class="text-sm text-slate-500">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-slate-500 mb-1">Total Amount</p>
                        <p class="font-black text-slate-900">₹{{ number_format($order->total_amount, 2) }}</p>
                    </div>
                </div>
                
                <div class="px-6 py-4 flex justify-between items-center">
                    <p class="text-sm font-bold text-slate-600">{{ $order->items()->count() }} item(s) in this order</p>
                    <div class="flex gap-3">
                        <a href="{{ route('customer.invoices.show', $order->order_number) }}" target="_blank" class="px-4 py-2 border border-slate-200 text-slate-600 hover:bg-slate-50 font-bold rounded-lg transition text-sm flex items-center gap-2">
                            <i data-lucide="file-text" class="w-4 h-4"></i> Invoice
                        </a>
                        <a href="{{ route('customer.orders.show', $order->order_number) }}" class="px-4 py-2 bg-slate-900 hover:bg-black text-white font-bold rounded-lg transition text-sm flex items-center gap-2">
                            <i data-lucide="eye" class="w-4 h-4"></i> View Details
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="mt-8">
        {{ $orders->links() }}
    </div>
@else
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-12 text-center">
        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
            <i data-lucide="shopping-bag" class="w-8 h-8"></i>
        </div>
        <h3 class="text-lg font-bold text-slate-900 mb-1">No orders yet</h3>
        <p class="text-slate-500 mb-6">Looks like you haven't placed an order yet.</p>
        <a href="{{ route('home') }}" class="inline-block bg-slate-900 hover:bg-black text-white font-bold py-3 px-8 rounded-xl shadow-sm transition">
            Start Shopping
        </a>
    </div>
@endif
@endsection
