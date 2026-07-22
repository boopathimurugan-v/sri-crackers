@extends('layouts.customer')

@section('title', 'My Wishlist')

@section('customer_content')
<h1 class="text-2xl font-bold text-slate-900 mb-6">My Wishlist</h1>

@if($wishlists->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($wishlists as $wishlist)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden group">
                <div class="aspect-w-1 aspect-h-1 bg-slate-100 relative">
                    @if($wishlist->product->main_image)
                        <img src="{{ asset('storage/products/' . $wishlist->product->main_image) }}" alt="{{ $wishlist->product->name }}" class="object-cover w-full h-full">
                    @else
                        <div class="flex items-center justify-center h-48 bg-slate-50 text-4xl">🎆</div>
                    @endif
                    
                    <form action="{{ route('customer.wishlist.destroy', $wishlist) }}" method="POST" class="absolute top-3 right-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-8 h-8 bg-white/90 backdrop-blur rounded-full flex items-center justify-center text-red-500 hover:bg-red-500 hover:text-white transition shadow-sm" title="Remove from Wishlist">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
                
                <div class="p-5">
                    <h3 class="font-bold text-slate-900 mb-1 truncate">{{ $wishlist->product->name }}</h3>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-lg font-black text-red-600">₹{{ number_format($wishlist->product->offer_price, 2) }}</span>
                        @if($wishlist->product->mrp > $wishlist->product->offer_price)
                            <span class="text-sm text-slate-400 line-through">₹{{ number_format($wishlist->product->mrp, 2) }}</span>
                        @endif
                    </div>
                    
                    <button @click="addToCart({{ json_encode(['name' => $wishlist->product->name, 'price' => $wishlist->product->offer_price, 'category' => $wishlist->product->category->name ?? 'Crackers']) }})" class="w-full bg-slate-900 hover:bg-black text-white font-bold py-2.5 rounded-xl transition flex items-center justify-center gap-2 text-sm">
                        <i data-lucide="shopping-cart" class="w-4 h-4"></i> Add to Cart
                    </button>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-12 text-center">
        <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4 text-red-400">
            <i data-lucide="heart" class="w-8 h-8"></i>
        </div>
        <h3 class="text-lg font-bold text-slate-900 mb-1">Your wishlist is empty</h3>
        <p class="text-slate-500 mb-6">Save items you love and buy them later.</p>
        <a href="{{ route('home') }}" class="inline-block bg-slate-900 hover:bg-black text-white font-bold py-3 px-8 rounded-xl shadow-sm transition">
            Explore Products
        </a>
    </div>
@endif
@endsection
