@extends('layouts.customer')

@section('title', 'My Addresses')

@section('customer_content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Saved Addresses</h1>
    <a href="{{ route('customer.addresses.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-sm transition flex items-center gap-2">
        <i data-lucide="plus" class="w-5 h-5"></i> Add New Address
    </a>
</div>

@if($addresses->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($addresses as $address)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 relative group">
                @if($address->is_default)
                    <div class="absolute top-6 right-6">
                        <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded-full uppercase tracking-wide">Default</span>
                    </div>
                @endif
                
                <div class="flex items-center gap-2 mb-4">
                    <i data-lucide="{{ $address->type == 'home' ? 'home' : ($address->type == 'work' ? 'briefcase' : 'map-pin') }}" class="w-5 h-5 text-slate-400"></i>
                    <h2 class="text-lg font-bold text-slate-900 capitalize">{{ $address->type }}</h2>
                </div>
                
                <div class="text-slate-600 text-sm space-y-1 mb-6">
                    <p class="font-bold text-slate-900">{{ $address->name }}</p>
                    <p>{{ $address->phone }}</p>
                    <p class="mt-2">{{ $address->address }}</p>
                    <p>{{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}</p>
                </div>
                
                <div class="flex items-center gap-3 border-t border-slate-100 pt-4">
                    <a href="{{ route('customer.addresses.edit', $address) }}" class="flex-1 text-center py-2 bg-slate-50 hover:bg-slate-100 text-slate-700 font-bold rounded-lg transition text-sm">
                        Edit
                    </a>
                    <form action="{{ route('customer.addresses.destroy', $address) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this address?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-2 bg-red-50 hover:bg-red-100 text-red-600 font-bold rounded-lg transition text-sm">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-12 text-center">
        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
            <i data-lucide="map-pin" class="w-8 h-8"></i>
        </div>
        <h3 class="text-lg font-bold text-slate-900 mb-1">No addresses saved</h3>
        <p class="text-slate-500 mb-6">You haven't added any shipping addresses yet.</p>
        <a href="{{ route('customer.addresses.create') }}" class="inline-block bg-slate-900 hover:bg-black text-white font-bold py-3 px-8 rounded-xl shadow-sm transition">
            Add Your First Address
        </a>
    </div>
@endif
@endsection
