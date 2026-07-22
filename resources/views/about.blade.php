@extends('layouts.store')

@section('title', 'About Us')

@section('content')
<div class="bg-amber-50/50">
    
    {!! '<!-- Hero -->' !!}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24 grid lg:grid-cols-2 gap-12 items-center">
        <div>
            <h1 class="text-4xl lg:text-5xl font-extrabold text-slate-900 mb-6 leading-tight">Bringing Light and Joy from <span class="text-red-600">Sivakasi</span> to Your Home.</h1>
            <p class="text-lg text-slate-600 mb-8 leading-relaxed">
                Sri Crackers has been a trusted name in the fireworks industry for over a decade. We are committed to providing premium quality, 100% safe, and eco-friendly green crackers directly from the heart of Sivakasi.
            </p>
            <div class="flex gap-4">
                <a href="{{ url('/categories') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold px-6 py-3 rounded-xl shadow-md transition">Shop Now</a>
                <a href="#contact" class="bg-white hover:bg-slate-50 text-slate-800 border border-slate-200 font-bold px-6 py-3 rounded-xl shadow-sm transition">Contact Us</a>
            </div>
        </div>
        <div class="relative">
            <div class="absolute inset-0 bg-gradient-to-tr from-amber-200 to-red-200 rounded-3xl transform rotate-3 scale-105 opacity-50"></div>
            <div class="bg-slate-900 rounded-3xl p-8 relative overflow-hidden shadow-2xl h-80 flex items-center justify-center">
                <div class="absolute text-[12rem] opacity-20">🎆</div>
                <div class="text-center relative z-10 text-white">
                    <span class="block text-5xl font-black text-amber-400 mb-2">10+</span>
                    <span class="block text-lg font-bold uppercase tracking-widest text-slate-300">Years of Trust</span>
                </div>
            </div>
        </div>
    </div>
</div>

{!! '<!-- Why Choose Us -->' !!}
<div class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl font-extrabold text-slate-900 mb-4">Why Choose Sri Crackers?</h2>
            <p class="text-slate-600">We don't just sell fireworks; we deliver memories. Here's why thousands of families trust us every festival season.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100 text-center hover:border-amber-200 hover:shadow-lg transition">
                <div class="bg-white w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm border border-slate-100 text-red-600">
                    <i data-lucide="factory" class="w-8 h-8"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Factory Direct Prices</h3>
                <p class="text-slate-600 text-sm">By cutting out the middlemen, we bring you authentic Sivakasi crackers at wholesale prices, saving you up to 80%.</p>
            </div>
            <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100 text-center hover:border-amber-200 hover:shadow-lg transition">
                <div class="bg-white w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm border border-slate-100 text-red-600">
                    <i data-lucide="shield-check" class="w-8 h-8"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">100% Green Crackers</h3>
                <p class="text-slate-600 text-sm">Our products are CSIR-NEERI certified green crackers, ensuring a safe and eco-friendly celebration with reduced emissions.</p>
            </div>
            <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100 text-center hover:border-amber-200 hover:shadow-lg transition">
                <div class="bg-white w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm border border-slate-100 text-red-600">
                    <i data-lucide="truck" class="w-8 h-8"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Fast & Safe Delivery</h3>
                <p class="text-slate-600 text-sm">We partner with verified transport agencies to ensure your festive packages arrive safely and on time across supported regions.</p>
            </div>
        </div>
    </div>
</div>

{!! '<!-- Vision/Mission -->' !!}
<div class="py-20 bg-slate-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-2 gap-16">
        <div>
            <h3 class="text-amber-400 font-bold tracking-widest uppercase text-sm mb-2">Our Mission</h3>
            <p class="text-2xl font-bold leading-snug mb-6">To provide every family with safe, spectacular, and affordable fireworks that make their celebrations unforgettable.</p>
            <p class="text-slate-400">We work tirelessly to source the best quality materials, enforce strict safety standards, and innovate in our product lines to bring you the brightest sparks and the most vibrant colors.</p>
        </div>
        <div>
            <h3 class="text-amber-400 font-bold tracking-widest uppercase text-sm mb-2">Our Vision</h3>
            <p class="text-2xl font-bold leading-snug mb-6">To be the most trusted and preferred online destination for Sivakasi fireworks in India.</p>
            <p class="text-slate-400">We aim to revolutionize the fireworks industry by promoting green crackers, ensuring transparent pricing, and delivering exceptional customer service at every touchpoint.</p>
        </div>
    </div>
</div>
@endsection
