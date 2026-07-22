@extends('layouts.store')

@section('title', $product->name)

@section('content')
<div class="bg-amber-50/50 py-12 border-b border-amber-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex text-sm text-slate-500 mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ url('/') }}" class="hover:text-red-600 transition">Home</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 mx-1"></i>
                        <a href="{{ url('/categories#' . $product->category->slug) }}" class="hover:text-red-600 transition">{{ $product->category->name }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 mx-1"></i>
                        <span class="text-slate-800 font-medium">{{ $product->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 bg-white rounded-3xl shadow-sm border border-amber-100 p-6 md:p-12">
            {!! '<!-- Product Images -->' !!}
            <div x-data="{ activeImage: '{{ Storage::url('products/' . $product->main_image) }}' }">
                <div class="aspect-square bg-slate-50 rounded-2xl border border-slate-100 overflow-hidden mb-4 relative">
                    <img :src="activeImage" alt="{{ $product->name }}" class="w-full h-full object-contain p-4 mix-blend-multiply">
                    @if($product->featured)
                        <div class="absolute top-4 left-4 bg-gradient-to-r from-red-600 to-amber-500 text-white text-xs font-black px-3 py-1.5 rounded-full shadow-md uppercase tracking-wider">
                            Featured
                        </div>
                    @endif
                </div>
                
                @if($product->images && $product->images->count() > 0)
                <div class="flex gap-4 overflow-x-auto pb-2">
                    <button @click="activeImage = '{{ Storage::url('products/' . $product->main_image) }}'" 
                            class="w-20 h-20 flex-shrink-0 bg-slate-50 rounded-xl border-2 transition-all"
                            :class="activeImage === '{{ Storage::url('products/' . $product->main_image) }}' ? 'border-red-500 shadow-md' : 'border-transparent hover:border-amber-300'">
                        <img src="{{ Storage::url('products/' . $product->main_image) }}" class="w-full h-full object-cover rounded-lg">
                    </button>
                    @foreach($product->images as $image)
                        <button @click="activeImage = '{{ Storage::url('products/gallery/' . $image->image_path) }}'" 
                                class="w-20 h-20 flex-shrink-0 bg-slate-50 rounded-xl border-2 transition-all"
                                :class="activeImage === '{{ Storage::url('products/gallery/' . $image->image_path) }}' ? 'border-red-500 shadow-md' : 'border-transparent hover:border-amber-300'">
                            <img src="{{ Storage::url('products/gallery/' . $image->image_path) }}" class="w-full h-full object-cover rounded-lg">
                        </button>
                    @endforeach
                </div>
                @endif
            </div>

            {!! '<!-- Product Info -->' !!}
            <div class="flex flex-col justify-center">
                @if($product->brand)
                    <span class="text-xs font-bold tracking-widest text-red-600 uppercase mb-2 block">{{ $product->brand }}</span>
                @endif
                
                <h1 class="text-3xl md:text-4xl font-black text-slate-800 mb-4 leading-tight">{{ $product->name }}</h1>
                
                <div class="flex items-center gap-4 mb-6">
                    <div class="flex flex-col">
                        @if($product->mrp > $product->offer_price)
                            <span class="text-sm text-slate-400 line-through font-semibold">₹{{ number_format($product->mrp, 2) }}</span>
                        @endif
                        <div class="text-3xl font-black text-red-600">
                            ₹{{ number_format($product->offer_price, 2) }}
                        </div>
                    </div>
                    @if($product->mrp > $product->offer_price)
                        <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-1 rounded-lg">
                            Save {{ round((($product->mrp - $product->offer_price) / $product->mrp) * 100) }}%
                        </span>
                    @endif
                </div>

                <p class="text-slate-600 leading-relaxed mb-8 text-lg">
                    {{ $product->short_description }}
                </p>

                <div class="space-y-4 border-t border-b border-slate-100 py-6 mb-8">
                    @if($product->sku)
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">SKU</span>
                        <span class="font-bold text-slate-800">{{ $product->sku }}</span>
                    </div>
                    @endif
                    @if($product->weight)
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Weight</span>
                        <span class="font-bold text-slate-800">{{ $product->weight }} kg</span>
                    </div>
                    @endif
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Availability</span>
                        @if($product->stock > 0)
                            <span class="font-bold text-green-600">In Stock</span>
                        @else
                            <span class="font-bold text-red-600">Out of Stock</span>
                        @endif
                    </div>
                </div>

                <div class="flex gap-4">
                    <button @click="addToCart({ id: {{ $product->id }}, name: '{{ addslashes($product->name) }}', price: {{ $product->offer_price }}, image: '{{ Storage::url('products/' . $product->main_image) }}', type: 'product' })" 
                            class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-xl transition shadow-lg shadow-red-200 flex items-center justify-center gap-2"
                            {{ $product->stock <= 0 ? 'disabled' : '' }}>
                        <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                        {{ $product->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                    </button>
                    @auth
                        <button @click="addToWishlist({{ $product->id }})" class="w-14 flex-shrink-0 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl flex items-center justify-center transition">
                            <i data-lucide="heart" class="w-5 h-5"></i>
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="w-14 flex-shrink-0 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl flex items-center justify-center transition">
                            <i data-lucide="heart" class="w-5 h-5"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        @if($product->long_description)
        <div class="mt-12 bg-white rounded-3xl shadow-sm border border-amber-100 p-8 md:p-12">
            <h2 class="text-2xl font-black text-slate-800 mb-6">Product Details</h2>
            <div class="prose prose-slate max-w-none text-slate-600">
                {!! nl2br(e($product->long_description)) !!}
            </div>
        </div>
        @endif
        
        @if($relatedProducts->count() > 0)
        <div class="mt-20">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-black text-slate-800 tracking-tight">Similar Products</h2>
                    <p class="text-slate-500 mt-2">More from {{ $product->category->name }}</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    <x-product-card :product="$related" />
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

{!! '<!-- Schema.org Product JSON-LD -->' !!}
<script type="application/ld+json">
{
  "@@context": "https://schema.org/",
  "@type": "Product",
  "name": "{{ $product->name }}",
  "image": [
    "{{ url(Storage::url('products/' . $product->main_image)) }}"
  ],
  "description": "{{ $product->short_description }}",
  "sku": "{{ $product->sku ?? $product->id }}",
  @if($product->brand)
  "brand": {
    "@type": "Brand",
    "name": "{{ $product->brand }}"
  },
  @endif
  "offers": {
    "@type": "Offer",
    "url": "{{ url()->current() }}",
    "priceCurrency": "INR",
    "price": "{{ $product->offer_price }}",
    "availability": "{{ $product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}"
  }
}
</script>

<script>
    function addToWishlist(productId) {
        fetch('{{ route("customer.wishlist.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ product_id: productId })
        }).then(response => {
            if (response.ok) {
                alert('Added to wishlist!');
            }
        });
    }
</script>
@endsection
