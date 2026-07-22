@extends('layouts.customer')

@section('title', 'Dashboard')

@section('customer_content')
<h1 class="text-2xl font-bold text-slate-900 mb-6">Overview</h1>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
            <i data-lucide="shopping-bag" class="w-6 h-6"></i>
        </div>
        <div>
            <p class="text-sm text-slate-500 font-bold">Total Orders</p>
            <p class="text-2xl font-black text-slate-900">{{ $user->orders()->count() }}</p>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center shrink-0">
            <i data-lucide="heart" class="w-6 h-6"></i>
        </div>
        <div>
            <p class="text-sm text-slate-500 font-bold">Wishlist Items</p>
            <p class="text-2xl font-black text-slate-900">{{ $wishlistCount }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
            <i data-lucide="map-pin" class="w-6 h-6"></i>
        </div>
        <div>
            <p class="text-sm text-slate-500 font-bold">Saved Addresses</p>
            <p class="text-2xl font-black text-slate-900">{{ $user->addresses()->count() }}</p>
        </div>
    </div>
</div>

<h2 class="text-xl font-bold text-slate-900 mb-4">Recent Orders</h2>
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    @if($recentOrders->count() > 0)
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4">Order ID</th>
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4">Total</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($recentOrders as $order)
                    <tr>
                        <td class="px-6 py-4 font-mono font-bold text-slate-900">{{ $order->order_number }}</td>
                        <td class="px-6 py-4 text-slate-500">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 font-bold">₹{{ number_format($order->total_amount, 2) }}</td>
                        <td class="px-6 py-4">
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
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $color }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('customer.orders.show', $order->order_number) }}" class="text-red-600 hover:text-red-800 font-bold transition">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="p-8 text-center text-slate-500">
            <i data-lucide="package" class="w-12 h-12 mx-auto mb-3 text-slate-300"></i>
            <p>You haven't placed any orders yet.</p>
            <a href="{{ route('home') }}" class="inline-block mt-4 text-red-600 font-bold hover:underline">Start Shopping</a>
        </div>
    @endif
</div>
@endsection
