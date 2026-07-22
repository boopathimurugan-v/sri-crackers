@extends('layouts.store')

@section('title', 'Price List')

@section('content')
@php
    $categories = config('store.categories', []);
    $allProducts = config('store.products', []);
@endphp

<div class="bg-amber-50/50 py-8 border-b border-amber-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-2">Wholesale Price List</h1>
            <p class="text-slate-600">Download our latest catalogue and price list for {{ date('Y') }}</p>
        </div>
        <div class="flex gap-3">
            <button onclick="window.print()" class="bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-bold px-4 py-2.5 rounded-xl shadow-sm transition flex items-center gap-2 text-sm">
                <i data-lucide="printer" class="w-4 h-4"></i> Print
            </button>
            <button class="bg-slate-900 hover:bg-slate-800 text-white font-bold px-4 py-2.5 rounded-xl shadow-sm transition flex items-center gap-2 text-sm">
                <i data-lucide="file-down" class="w-4 h-4"></i> PDF
            </button>
            <button class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-4 py-2.5 rounded-xl shadow-sm transition flex items-center gap-2 text-sm">
                <i data-lucide="sheet" class="w-4 h-4"></i> Excel
            </button>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="{
    search: '',
    activeTab: 'All',
    categories: ['All', ...{{ json_encode($categories) }}],
    
    get filteredProducts() {
        const products = {{ json_encode($allProducts) }};
        return products.filter(p => {
            const matchesSearch = p.name.toLowerCase().includes(this.search.toLowerCase());
            const matchesCategory = this.activeTab === 'All' ? true : p.category === this.activeTab;
            return matchesSearch && matchesCategory;
        });
    }
}">
    
    {!! '<!-- Controls -->' !!}
    <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-8">
        
        {!! '<!-- Category Tabs (Desktop) / Select (Mobile) -->' !!}
        <div class="w-full md:w-auto overflow-x-auto custom-scrollbar pb-2 md:pb-0">
            <div class="flex space-x-2">
                <template x-for="cat in categories" :key="cat">
                    <button 
                        @click="activeTab = cat" 
                        :class="activeTab === cat ? 'bg-red-600 text-white border-transparent' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50'"
                        class="px-4 py-2 rounded-lg border font-medium text-sm whitespace-nowrap transition-colors"
                        x-text="cat"
                    ></button>
                </template>
            </div>
        </div>

        {!! '<!-- Search -->' !!}
        <div class="w-full md:w-64 shrink-0 relative">
            <i data-lucide="search" class="w-4 h-4 absolute left-3 top-2.5 text-slate-400"></i>
            <input type="text" x-model="search" placeholder="Search price list..." class="w-full pl-9 pr-4 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-red-500 outline-none text-sm shadow-sm">
        </div>
    </div>

    {!! '<!-- Table -->' !!}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden printable-area">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="py-4 px-6 font-bold text-slate-900 text-sm">Product Name</th>
                        <th class="py-4 px-6 font-bold text-slate-900 text-sm">Category</th>
                        <th class="py-4 px-6 font-bold text-slate-900 text-sm text-center">Discount</th>
                        <th class="py-4 px-6 font-bold text-slate-900 text-sm text-right">MRP</th>
                        <th class="py-4 px-6 font-bold text-slate-900 text-sm text-right">Factory Price</th>
                        <th class="py-4 px-6 font-bold text-slate-900 text-sm text-center no-print">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <template x-for="product in filteredProducts" :key="product.id">
                        <tr class="hover:bg-amber-50/50 transition">
                            <td class="py-3 px-6 text-sm font-semibold text-slate-800">
                                <span class="mr-2" x-text="product.image_icon"></span>
                                <span x-text="product.name"></span>
                            </td>
                            <td class="py-3 px-6 text-xs text-slate-500 font-medium tracking-wide uppercase" x-text="product.category"></td>
                            <td class="py-3 px-6 text-center">
                                <span x-show="product.discount" class="inline-block bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded" x-text="product.discount + ' OFF'"></span>
                            </td>
                            <td class="py-3 px-6 text-right text-sm text-slate-500 line-through" x-text="product.original_price ? '₹' + product.original_price.toLocaleString() : '-'"></td>
                            <td class="py-3 px-6 text-right text-base font-extrabold text-slate-900" x-text="'₹' + product.price.toLocaleString()"></td>
                            <td class="py-3 px-6 text-center no-print">
                                <button x-show="product.stock > 0" @click="addToCart(product)" class="text-red-600 hover:text-red-700 font-bold text-sm bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition">
                                    Add
                                </button>
                                <span x-show="product.stock == 0" class="text-xs text-slate-400 font-bold bg-slate-100 px-3 py-1.5 rounded-lg">Out of stock</span>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="filteredProducts.length === 0" x-cloak>
                        <td colspan="6" class="py-12 text-center text-slate-500">
                            No products found matching your criteria.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .printable-area, .printable-area * {
            visibility: visible;
        }
        .printable-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            box-shadow: none !important;
            border: none !important;
        }
        .no-print {
            display: none !important;
        }
    }
</style>
@endsection
