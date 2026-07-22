@extends('layouts.store')

@section('title', 'Homepage')

@section('content')

{!! '<!-- Hero Section -->' !!}
@if($banner)
<section id="home" class="relative overflow-hidden bg-gradient-to-b from-amber-100/60 via-amber-50/20 to-white pt-12 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            
            {!! '<!-- Left Content -->' !!}
            <div class="space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 bg-amber-100 border border-amber-300 text-amber-800 text-xs font-bold px-3 py-1.5 rounded-full">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-600"></i> 100% Safe & Certified Green Crackers
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    {{ $banner->title }}
                </h1>
                
                @if($banner->link)
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start pt-2">
                    <a href="{{ $banner->link }}" class="bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-3.5 rounded-xl shadow-lg shadow-red-200 transition text-center">
                        Explore Now
                    </a>
                </div>
                @endif
            </div>

            {!! '<!-- Right Visual Card -->' !!}
            <div class="relative">
                <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}" class="rounded-3xl shadow-2xl relative z-10 w-full object-cover" style="max-height: 400px;">
            </div>

        </div>
    </div>
</section>
@else
<section id="home" class="relative overflow-hidden bg-gradient-to-b from-amber-100/60 via-amber-50/20 to-white pt-12 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            
            {!! '<!-- Left Content -->' !!}
            <div class="space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 bg-amber-100 border border-amber-300 text-amber-800 text-xs font-bold px-3 py-1.5 rounded-full">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-600"></i> 100% Safe & Certified Green Crackers
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Brighten Your Celebrations with <span class="text-red-600">Sri Crackers</span>
                </h1>
                <p class="text-lg text-slate-600 max-w-xl mx-auto lg:mx-0">
                    Directly sourced from Sivakasi. Premium quality, best market prices, and safe delivery for all your festive occasions.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start pt-2">
                    <a href="#pricelist" class="bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-3.5 rounded-xl shadow-lg shadow-red-200 transition text-center">
                        Download Price List
                    </a>
                    <a href="#combos" class="bg-white hover:bg-slate-50 text-slate-800 border border-slate-200 font-bold px-8 py-3.5 rounded-xl shadow-sm transition text-center">
                        View Combo Packs
                    </a>
                </div>

                {!! '<!-- Quick Trust Badges -->' !!}
                <div class="grid grid-cols-3 gap-4 pt-6 border-t border-amber-200/60">
                    <div>
                        <h4 class="font-extrabold text-slate-900 text-lg">100%</h4>
                        <p class="text-xs text-slate-500">Original Sivakasi</p>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-slate-900 text-lg">80% OFF</h4>
                        <p class="text-xs text-slate-500">Factory Discount</p>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-slate-900 text-lg">Safe</h4>
                        <p class="text-xs text-slate-500">Green Crackers</p>
                    </div>
                </div>
            </div>

            {!! '<!-- Right Visual Card -->' !!}
            <div class="relative">
                <div class="bg-gradient-to-tr from-red-600 to-amber-500 p-8 rounded-3xl shadow-2xl text-white relative z-10 overflow-hidden">
                    <div class="absolute top-0 right-0 opacity-10 text-9xl font-black">✨</div>
                    <span class="bg-amber-300 text-red-950 font-black text-xs px-3 py-1 rounded-full uppercase tracking-wider">
                        Bestseller Package
                    </span>
                    <h3 class="text-3xl font-extrabold mt-4 mb-2">Mega Family Cracker Box</h3>
                    <p class="text-amber-100 text-sm mb-6">45 Premium Crackers items included for complete family entertainment.</p>
                    <div class="flex items-baseline gap-3 mb-6">
                        <span class="text-4xl font-black">₹2,499</span>
                        <span class="text-amber-200 line-through text-lg">₹5,000</span>
                    </div>
                    <button @click="addToCart({ name: 'Mega Family Cracker Box', category: 'Combo Packs', price: 2499 })" class="w-full bg-white text-red-600 font-black py-3.5 rounded-xl hover:bg-amber-50 shadow-md transition transform active:scale-95">
                        Order Combo Pack Now
                    </button>
                </div>
            </div>

        </div>
    </div>
</section>
@endif

{!! '<!-- Features Bar -->' !!}
<section class="bg-white border-y border-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="flex items-center gap-4 p-4 rounded-xl bg-amber-50/50 border border-amber-100">
            <i data-lucide="shield-check" class="w-8 h-8 text-red-600"></i>
            <div>
                <h5 class="font-bold text-slate-800">Certified Quality</h5>
                <p class="text-xs text-slate-500">100% Eco-friendly green crackers</p>
            </div>
        </div>
        <div class="flex items-center gap-4 p-4 rounded-xl bg-amber-50/50 border border-amber-100">
            <i data-lucide="truck" class="w-8 h-8 text-red-600"></i>
            <div>
                <h5 class="font-bold text-slate-800">Prompt Transport</h5>
                <p class="text-xs text-slate-500">Delivered directly from factory hubs</p>
            </div>
        </div>
        <div class="flex items-center gap-4 p-4 rounded-xl bg-amber-50/50 border border-amber-100">
            <i data-lucide="phone" class="w-8 h-8 text-red-600"></i>
            <div>
                <h5 class="font-bold text-slate-800">Direct Support</h5>
                <p class="text-xs text-slate-500">Instant WhatsApp & phone ordering</p>
            </div>
        </div>
    </div>
</section>

{!! '<!-- Dynamic Product Sections -->' !!}

{!! '<!-- Featured Products Section -->' !!}
@if(count($featuredProducts) > 0)
<section class="py-16 bg-slate-50/50 border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900">Featured Products</h2>
                <p class="text-slate-500 text-sm mt-1">Our top picks and best sellers for the season</p>
            </div>
            <a href="{{ url('/categories') }}" class="text-red-600 font-bold text-sm hover:underline">View All →</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $prod)
                <x-product-card :product="$prod" />
            @endforeach
        </div>
    </div>
</section>
@endif

{!! '<!-- Trending Products Section -->' !!}
@if(count($trendingProducts) > 0)
<section class="py-16 bg-white border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900">Trending Now</h2>
                <p class="text-slate-500 text-sm mt-1">What everyone is buying right now</p>
            </div>
            <a href="{{ url('/categories') }}" class="text-red-600 font-bold text-sm hover:underline">View All →</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($trendingProducts as $prod)
                <x-product-card :product="$prod" />
            @endforeach
        </div>
    </div>
</section>
@endif

{!! '<!-- Latest Products Section -->' !!}
@if(count($latestProducts) > 0)
<section class="py-16 bg-slate-50/50 border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900">New Arrivals</h2>
                <p class="text-slate-500 text-sm mt-1">Check out our latest additions</p>
            </div>
            <a href="{{ url('/categories') }}" class="text-red-600 font-bold text-sm hover:underline">View All →</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($latestProducts as $prod)
                <x-product-card :product="$prod" />
            @endforeach
        </div>
    </div>
</section>
@endif

{!! '<!-- Festival Offers Section -->' !!}
@if(count($festivalOffers) > 0)
<section class="py-16 bg-amber-50 border-t border-amber-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900">Festival Special Offers</h2>
                <p class="text-amber-700 text-sm mt-1 font-bold">Limited time deals for the upcoming festival</p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($festivalOffers as $offer)
                <div class="bg-white rounded-2xl border border-amber-200 overflow-hidden shadow-sm flex flex-col relative">
                    <div class="absolute top-4 right-4 z-20">
                        <span class="bg-red-600 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full shadow-sm">
                            {{ $offer->discount_percentage }}% OFF
                        </span>
                    </div>
                    <div class="h-40 bg-amber-100/50 flex items-center justify-center relative overflow-hidden">
                        @if($offer->image)
                            <img src="{{ Storage::url($offer->image) }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-6xl">🎁</span>
                        @endif
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <h4 class="font-bold text-slate-800 text-xl leading-snug mb-2">{{ $offer->title }}</h4>
                            <p class="text-slate-600 text-sm line-clamp-3">{{ $offer->description }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{!! '<!-- Category Sections -->' !!}
@foreach($categories as $categoryName)
    @php
        // Filter products for this specific category
        $categoryProducts = collect($allProducts)->where('category', $categoryName)->all();
    @endphp

    @if(count($categoryProducts) > 0)
    <section class="py-16 {{ $loop->iteration % 2 == 0 ? 'bg-white' : 'bg-slate-50/50' }} border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h2 class="text-3xl font-extrabold text-slate-900">{{ $categoryName }}</h2>
                    <p class="text-slate-500 text-sm mt-1">Explore our wide range of {{ strtolower($categoryName) }}</p>
                </div>
                <a href="{{ url('/categories?category=' . urlencode($categoryName)) }}" class="text-red-600 font-bold text-sm hover:underline">View All {{ $categoryName }} →</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($categoryProducts as $prod)
                    <x-product-card :product="$prod" />
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endforeach

{!! '<!-- Combos Section -->' !!}
@if(count($combos) > 0)
<section id="combos" class="py-16 bg-gradient-to-b from-amber-50 to-white border-t border-amber-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900">Family Combo Packs</h2>
                <p class="text-slate-500 text-sm mt-1">Maximum fun, unbeatable value packages</p>
            </div>
            <a href="{{ url('/combos') }}" class="text-red-600 font-bold text-sm hover:underline">View All Combos →</a>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @foreach($combos as $combo)
                <x-combo-card :combo="$combo" />
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection