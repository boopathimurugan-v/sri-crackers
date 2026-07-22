@extends('layouts.store')

@section('title', 'Categories')

@section('content')
@php
    // Data is now passed from FrontendController
@endphp

<div class="bg-amber-50/50 py-8 border-b border-amber-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-2">All Products</h1>
        <p class="text-slate-600">Browse our complete collection of high-quality Sivakasi crackers.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="{
    search: '',
    selectedCategory: new URLSearchParams(location.search).get('category') || '',
    selectedBrands: [],
    minPrice: '',
    maxPrice: '',
    isMobileFilterOpen: false,
    
    get filteredProducts() {
        const products = {{ json_encode($allProducts) }};
        return products.filter(p => {
            const matchesSearch = p.name.toLowerCase().includes(this.search.toLowerCase());
            const matchesCategory = this.selectedCategory ? p.category === this.selectedCategory : true;
            const matchesMinPrice = this.minPrice ? p.price >= parseInt(this.minPrice) : true;
            const matchesMaxPrice = this.maxPrice ? p.price <= parseInt(this.maxPrice) : true;
            
            return matchesSearch && matchesCategory && matchesMinPrice && matchesMaxPrice;
        });
    }
}">
    <div class="flex flex-col lg:flex-row gap-8">
        
        {!! '<!-- Mobile Filter Toggle -->' !!}
        <div class="lg:hidden">
            <button @click="isMobileFilterOpen = !isMobileFilterOpen" class="w-full bg-white border border-slate-200 text-slate-700 font-bold py-3 rounded-xl flex items-center justify-center gap-2 shadow-sm">
                <i data-lucide="sliders-horizontal" class="w-4 h-4"></i> Filters
            </button>
        </div>

        {!! '<!-- Sidebar Filters -->' !!}
        <aside class="w-full lg:w-1/4" :class="isMobileFilterOpen ? 'block' : 'hidden lg:block'">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-8 sticky top-24">
                
                {!! '<!-- Search -->' !!}
                <div>
                    <h3 class="font-bold text-slate-900 mb-3">Search</h3>
                    <div class="relative">
                        <i data-lucide="search" class="w-4 h-4 absolute left-3 top-3 text-slate-400"></i>
                        <input type="text" x-model="search" placeholder="Find crackers..." class="w-full pl-9 pr-4 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition text-sm">
                    </div>
                </div>

                {!! '<!-- Category Filter -->' !!}
                <div>
                    <h3 class="font-bold text-slate-900 mb-3">Categories</h3>
                    <div class="space-y-2 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" x-model="selectedCategory" value="" class="w-4 h-4 text-red-600 focus:ring-red-500 border-slate-300">
                            <span class="text-sm text-slate-600 group-hover:text-slate-900 transition">All Categories</span>
                        </label>
                        @foreach($categories as $cat)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" x-model="selectedCategory" value="{{ $cat }}" class="w-4 h-4 text-red-600 focus:ring-red-500 border-slate-300">
                            <span class="text-sm text-slate-600 group-hover:text-slate-900 transition">{{ $cat }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {!! '<!-- Price Filter -->' !!}
                <div>
                    <h3 class="font-bold text-slate-900 mb-3">Price Range</h3>
                    <div class="flex items-center gap-2">
                        <input type="number" x-model="minPrice" placeholder="Min" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-red-500 outline-none text-sm">
                        <span class="text-slate-400">-</span>
                        <input type="number" x-model="maxPrice" placeholder="Max" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-red-500 outline-none text-sm">
                    </div>
                </div>
                
                {!! '<!-- Availability Filter -->' !!}
                <div>
                    <h3 class="font-bold text-slate-900 mb-3">Availability</h3>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" class="w-4 h-4 text-red-600 rounded focus:ring-red-500 border-slate-300">
                        <span class="text-sm text-slate-600 group-hover:text-slate-900 transition">In Stock Only</span>
                    </label>
                </div>

            </div>
        </aside>

        {!! '<!-- Product Grid -->' !!}
        <div class="w-full lg:w-3/4">
            {!! '<!-- Toolbar -->' !!}
            <div class="flex flex-col sm:flex-row justify-between items-center bg-white p-4 rounded-2xl border border-slate-100 shadow-sm mb-6 gap-4">
                <p class="text-sm text-slate-500"><span class="font-bold text-slate-900" x-text="filteredProducts.length"></span> products found</p>
                
                <div class="flex items-center gap-2">
                    <label class="text-sm text-slate-500">Sort by:</label>
                    <select class="border border-slate-200 rounded-lg px-3 py-1.5 text-sm outline-none focus:ring-2 focus:ring-red-500">
                        <option>Recommended</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Newest Arrivals</option>
                    </select>
                </div>
            </div>

            {!! '<!-- Grid -->' !!}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" x-show="filteredProducts.length > 0">
                <template x-for="product in filteredProducts" :key="product.id">
                    {!! '<!-- Using Alpine template to render cards client-side for immediate filtering -->' !!}
                    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col group">
                        <div class="h-44 bg-amber-50/60 flex items-center justify-center text-5xl relative group-hover:bg-amber-100/60 transition overflow-hidden">
                            <template x-if="product.image_path">
                                <img :src="'/storage/' + product.image_path" :alt="product.name" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!product.image_path">
                                <span x-text="product.image_icon"></span>
                            </template>
                            
                            <span x-show="product.discount" class="absolute top-3 right-3 bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full z-10" x-text="product.discount + ' OFF'"></span>
                            
                            <div x-show="product.stock == 0" class="absolute inset-0 bg-slate-900/40 backdrop-blur-[1px] flex items-center justify-center z-10">
                                <span class="bg-slate-800 text-white font-bold px-4 py-1.5 rounded-lg text-sm tracking-wide uppercase">Out of Stock</span>
                            </div>

                            <div class="absolute inset-x-0 bottom-0 p-3 opacity-0 group-hover:opacity-100 transition-opacity flex justify-center gap-2 z-20">
                                <button class="bg-white/90 hover:bg-white text-slate-700 p-2 rounded-full shadow-sm tooltip" title="Quick View">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </button>
                                <button class="bg-white/90 hover:bg-white text-slate-700 hover:text-red-600 p-2 rounded-full shadow-sm tooltip" title="Add to Wishlist">
                                    <i data-lucide="heart" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <span class="text-[10px] uppercase font-bold tracking-wider text-amber-600 block mb-1" x-text="product.category"></span>
                                <h4 class="font-bold text-slate-800 text-base leading-snug line-clamp-2" x-text="product.name"></h4>
                                <div class="flex items-baseline gap-2 mt-3 mb-4">
                                    <span class="text-xl font-extrabold text-slate-900" x-text="'₹' + product.price.toLocaleString()"></span>
                                    <span x-show="product.original_price" class="text-xs text-slate-400 line-through" x-text="'₹' + product.original_price?.toLocaleString()"></span>
                                </div>
                            </div>
                            
                            <button x-show="product.stock > 0" 
                                @click="addToCart(product)" 
                                class="w-full bg-amber-50 hover:bg-red-600 hover:text-white text-red-600 font-bold py-2.5 rounded-xl border border-amber-200 hover:border-transparent transition text-sm transform active:scale-95 flex items-center justify-center gap-2">
                                + Add to Cart
                            </button>
                            <button x-show="product.stock == 0" disabled class="w-full bg-slate-100 text-slate-400 font-bold py-2.5 rounded-xl border border-slate-200 cursor-not-allowed text-sm flex items-center justify-center gap-2">
                                Out of Stock
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            {!! '<!-- Empty State -->' !!}
            <div x-show="filteredProducts.length === 0" class="bg-white rounded-2xl border border-slate-100 p-12 text-center" x-cloak>
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4">
                    <i data-lucide="search-x" class="w-8 h-8 text-slate-400"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">No products found</h3>
                <p class="text-slate-500 mb-6">Try adjusting your filters or search term to find what you're looking for.</p>
                <button @click="search = ''; selectedCategory = ''; minPrice = ''; maxPrice = ''" class="text-red-600 font-bold hover:underline">Clear all filters</button>
            </div>
            
        </div>
    </div>
</div>
@endsection
