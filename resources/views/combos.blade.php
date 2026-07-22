@extends('layouts.store')

@section('title', 'Combo Offers')

@section('content')
@php
    // Data is now passed from FrontendController
@endphp

<div class="bg-gradient-to-r from-red-600 to-amber-600 py-12 border-b border-red-700 text-white text-center relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCI+PHBhdGggZD0iTTExLjUgMWMwIC45LjcgbSAxLjUgMS41LjcgMi41bDEuNSAxLjVWMThsLTEuNSAxLjUtMS41Ljc1LTEuNS43NS0uNzUgMS41TDggMjNsLTEuNS0uNzUtMS41LS43NVYyMWwtMS41LS43NWMwLS45LS43LTItMS41LTEuNWwtMS41LTEuNXYtMS41bDcuNS0uNzVWNmgxLjVWNGwxLjUtMS41eiIgZmlsbD0iI2ZmZmZmZjIwIi8+PC9zdmc+')] opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <span class="bg-white/20 text-white text-xs font-black px-3 py-1 rounded-full uppercase tracking-widest mb-4 inline-block backdrop-blur-sm border border-white/30">Up to 80% OFF</span>
        <h1 class="text-3xl md:text-5xl font-extrabold mb-4 tracking-tight drop-shadow-md">Exclusive Family Combo Packs</h1>
        <p class="text-amber-100 max-w-2xl mx-auto text-lg drop-shadow-sm">Maximum fun, unbeatable value. Handpicked assortments of our safest and most spectacular crackers for the perfect celebration.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    
    @if(count($combos) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($combos as $combo)
                <x-combo-card :combo="$combo" />
            @endforeach
        </div>
    @else
        <div class="bg-amber-50 rounded-2xl border border-amber-100 p-12 text-center">
            <div class="text-6xl mb-4">📦</div>
            <h3 class="text-2xl font-bold text-slate-900 mb-2">No Combo Packs Available</h3>
            <p class="text-slate-600">We are currently updating our combo offers for the season. Please check back soon!</p>
        </div>
    @endif
    
    {!! '<!-- Custom Combo CTA -->' !!}
    <div class="mt-20 bg-slate-900 rounded-3xl overflow-hidden shadow-2xl relative">
        <div class="absolute top-0 right-0 p-8 opacity-10 text-white">
            <i data-lucide="gift" class="w-48 h-48"></i>
        </div>
        <div class="p-8 md:p-12 relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="max-w-xl text-center md:text-left">
                <h3 class="text-2xl md:text-3xl font-extrabold text-white mb-3">Want a Custom Combo?</h3>
                <p class="text-slate-400">Can't find exactly what you're looking for? Contact our wholesale team to build a custom package tailored for your specific celebration needs.</p>
            </div>
            <a href="{{ url('/contact') }}" class="shrink-0 bg-white hover:bg-amber-50 text-slate-900 font-bold px-8 py-4 rounded-xl shadow-lg transition-transform hover:-translate-y-1">
                Contact Sales Team
            </a>
        </div>
    </div>

</div>
@endsection
