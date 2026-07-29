@extends('layouts.store')

@section('title', 'Sivakasi Fireworks - Direct Factory Price')

@section('content')

    <!-- ==========================================
         1. HERO BANNER
         ========================================== -->
    <section class="relative bg-black w-full overflow-hidden">
        @if($banners->count() > 0)
            @php $banner = $banners->first(); @endphp
            <div class="relative w-full h-[500px] md:h-[600px]">
                <img src="{{ $banner->image_path }}" alt="Banner" class="w-full h-full object-cover opacity-60">
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
                
                <div class="absolute inset-0 flex items-center">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full flex flex-col md:flex-row items-center justify-between">
                        
                        <div class="max-w-xl text-left">
                            <h1 class="text-5xl md:text-7xl font-black text-white leading-tight uppercase mb-4 drop-shadow-lg">
                                Sivakasi Original<br><span class="text-[#FFC000]">Crackers</span>
                            </h1>
                            <p class="text-lg md:text-xl text-gray-200 mb-8 font-medium">Factory Direct Price • Up to 80% Discount • Eco Friendly Green Crackers</p>
                            
                            <div class="flex gap-4">
                                <a href="#quick-order" class="bg-[#FFC000] text-slate-900 px-8 py-3 rounded-md font-black uppercase tracking-wider hover:bg-[#e5ac00] shadow-lg transition-colors">
                                    Shop Now
                                </a>
                                <a href="{{ url('/price-list') }}" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-md font-bold uppercase tracking-wider hover:bg-white hover:text-black shadow-lg transition-colors">
                                    View Price List
                                </a>
                            </div>
                        </div>

                        <div class="hidden md:block">
                            <!-- Floating Offer Card -->
                            <div class="bg-[#910A67] p-8 rounded-xl shadow-[0_20px_50px_rgba(145,10,103,0.5)] border-2 border-[#FFC000] animate-bounce-slow transform rotate-3">
                                <h3 class="text-[#FFC000] text-xl font-black uppercase tracking-widest text-center mb-2">Festival Sale</h3>
                                <div class="text-white text-6xl font-black text-center leading-none">80%</div>
                                <div class="text-[#FFC000] text-3xl font-black text-center mt-1 uppercase">OFF</div>
                                <div class="mt-4 pt-4 border-t border-pink-800 text-white font-bold text-center uppercase tracking-wider text-sm">
                                    100% Original <br> Safe Delivery
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>

    <!-- ==========================================
         FEATURED BRANDS
         ========================================== -->
    <section class="py-12 bg-gray-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-black text-slate-900 uppercase tracking-wide mb-8 text-center border-b-2 border-[#FFC000] pb-2 inline-block">Top Brands</h2>
            <div class="flex flex-wrap justify-center gap-8">
                @foreach($brands as $brand)
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow cursor-pointer flex flex-col items-center justify-center w-32 h-32 md:w-48 md:h-48">
                        <img src="{{ $brand->logo_path }}" alt="{{ $brand->name }}" class="w-full h-auto object-contain">
                        <span class="mt-4 font-bold text-slate-700 text-sm uppercase text-center">{{ $brand->name }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ==========================================
         2. QUICK ORDER SECTION
         ========================================== -->
    <section id="quick-order" class="py-16 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-12">
                <h2 class="text-4xl font-black text-slate-900 uppercase">Quick Order Calculator</h2>
                <p class="text-slate-500 font-medium mt-2">Select quantity and instantly know your savings.</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                
                <!-- Left: Products Grid (Grouped by Category) -->
                <div class="w-full lg:w-3/4">
                    @foreach($categories as $category)
                        @if($category->products->count() > 0)
                            <div class="mb-10">
                                <h3 class="bg-[#FFC000] text-slate-900 text-xl font-black px-4 py-2 uppercase rounded-t-md border-b-4 border-[#910A67] shadow-sm">
                                    {{ $category->name }}
                                </h3>
                                <div class="bg-white border border-gray-200 border-t-0 rounded-b-md shadow-sm overflow-hidden">
                                    
                                    <!-- Table Header (Desktop) -->
                                    <div class="hidden md:grid grid-cols-12 gap-4 bg-gray-50 p-4 border-b border-gray-200 font-bold text-sm text-slate-600 uppercase tracking-wider">
                                        <div class="col-span-2">Image</div>
                                        <div class="col-span-4">Product Name</div>
                                        <div class="col-span-2 text-center">MRP</div>
                                        <div class="col-span-2 text-center">Offer Price</div>
                                        <div class="col-span-2 text-center">Quantity</div>
                                    </div>

                                    <!-- Product Rows -->
                                    @foreach($category->products as $product)
                                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 p-4 items-center border-b border-gray-100 last:border-0 hover:bg-pink-50/30 transition-colors">
                                            
                                            <div class="col-span-1 md:col-span-2">
                                                <div class="relative w-20 h-20 md:w-24 md:h-24 rounded-lg overflow-hidden border border-gray-200 bg-white">
                                                    <img src="{{ $product->main_image ?: $product->image_path }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                                    <div class="absolute top-0 left-0 bg-[#910A67] text-white text-[9px] font-black px-1.5 py-0.5 rounded-br-md">
                                                        {{ $product->discount_percentage }}% OFF
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-span-1 md:col-span-4 flex flex-col">
                                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">{{ $product->brand->name ?? 'Premium' }}</span>
                                                <h4 class="font-black text-slate-900 text-base leading-snug">{{ $product->name }}</h4>

                                            </div>
                                            
                                            <div class="col-span-1 md:col-span-2 text-left md:text-center">
                                                <span class="md:hidden text-xs text-gray-500 font-bold uppercase mr-2">MRP:</span>
                                                <span class="text-gray-400 font-bold line-through">₹{{ number_format($product->mrp, 2) }}</span>
                                            </div>
                                            
                                            <div class="col-span-1 md:col-span-2 text-left md:text-center">
                                                <span class="md:hidden text-xs text-gray-500 font-bold uppercase mr-2">Offer:</span>
                                                <span class="text-xl font-black text-[#910A67]">₹{{ number_format($product->offer_price, 2) }}</span>
                                            </div>
                                            
                                            <div class="col-span-1 md:col-span-2 flex justify-start md:justify-center">
                                                <div class="flex items-center border-2 border-[#910A67] rounded-md overflow-hidden bg-white w-28">
                                                    <button type="button" @click="updateQty({{ json_encode($product) }}, -1)" class="w-8 py-1.5 bg-[#910A67]/10 text-[#910A67] hover:bg-[#910A67] hover:text-white transition font-black text-lg">-</button>
                                                    <input type="number" readonly :value="getQty({{ $product->id }})" class="w-12 text-center text-sm font-black bg-transparent text-slate-900 focus:outline-none p-0 border-none">
                                                    <button type="button" @click="updateQty({{ json_encode($product) }}, 1)" class="w-8 py-1.5 bg-[#910A67]/10 text-[#910A67] hover:bg-[#910A67] hover:text-white transition font-black text-lg">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Right: Sticky Summary -->
                <div class="w-full lg:w-1/4">
                    <div class="sticky top-28 bg-[#910A67] text-white rounded-xl shadow-xl overflow-hidden border-2 border-[#FFC000]">
                        <div class="bg-[#FFC000] text-slate-900 p-4 font-black uppercase text-center tracking-widest">
                            Your Order
                        </div>
                        
                        <div class="p-6 space-y-4">
                            <div class="flex justify-between items-center pb-4 border-b border-pink-800">
                                <span class="font-bold text-pink-200">Total Items</span>
                                <span class="font-black text-xl" x-text="cartCount"></span>
                            </div>
                            
                            <div class="flex justify-between items-center pb-4 border-b border-pink-800">
                                <span class="font-bold text-pink-200">Total MRP</span>
                                <span class="font-bold text-pink-300 line-through" x-text="`₹${totalMrp.toLocaleString('en-IN')}`"></span>
                            </div>

                            <div class="flex justify-between items-center pb-4 border-b border-pink-800">
                                <span class="font-bold text-[#FFC000]">Total Savings</span>
                                <span class="font-black text-[#FFC000] text-lg" x-text="`₹${totalSavings.toLocaleString('en-IN')}`"></span>
                            </div>

                            <div class="pt-2 pb-4">
                                <div class="text-sm font-bold text-pink-200 uppercase tracking-widest text-center mb-1">Payable Amount</div>
                                <div class="text-4xl font-black text-center text-white drop-shadow-md" x-text="`₹${totalPayable.toLocaleString('en-IN')}`"></div>
                            </div>

                            <a href="#checkout" class="block w-full py-4 bg-[#FFC000] text-slate-900 text-center font-black rounded-lg uppercase tracking-widest hover:bg-[#e5ac00] transition-colors shadow-lg shadow-yellow-500/20">
                                Checkout Now
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ==========================================
         SEO SECTION
         ========================================== -->
    @if($seoSections->count() > 0)
        <section class="py-16 bg-slate-100 border-t border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    @foreach($seoSections as $section)
                        <div>
                            <h2 class="text-2xl font-black text-[#910A67] uppercase mb-4">{{ $section->title }}</h2>
                            <div class="prose prose-sm prose-slate max-w-none font-medium leading-relaxed">
                                {!! $section->content !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection