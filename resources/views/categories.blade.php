@extends('layouts.store')

@section('title', '3D Luxury Collections - SRI CRACKERS')

@section('content')
<!-- Custom 3D Luxury Dark Theme Styling -->
<style>
    :root {
        --color-navy: #081B2D;
        --color-navy-card: rgba(13, 34, 56, 0.75);
        --color-gold: #FFC107;
        --color-gold-bright: #FFE066;
        --color-gold-dark: #B8860B;
        --color-orange-glow: #FF6B00;
    }

    body {
        background-color: var(--color-navy) !important;
        color: #F1F5F9;
        font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    /* Glassmorphism utility */
    .glass-card {
        background: rgba(11, 31, 51, 0.65);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 193, 7, 0.25);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }

    .glass-card-interactive {
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .glass-card-interactive:hover {
        transform: translateY(-12px) scale(1.02);
        border-color: rgba(255, 193, 7, 0.75);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.7), 0 0 35px rgba(255, 193, 7, 0.35);
    }

    /* Metallic Gold Text Gradient */
    .gold-gradient-text {
        background: linear-gradient(135deg, #FFF5C0 0%, #FFC107 40%, #E69D00 70%, #FFF5C0 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0 0 20px rgba(255, 193, 7, 0.3);
    }

    .gold-gradient-btn {
        background: linear-gradient(135deg, #FFD700 0%, #FFC107 50%, #D4AF37 100%);
        box-shadow: 0 10px 25px rgba(255, 193, 7, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.4);
        transition: all 0.3s ease;
    }

    .gold-gradient-btn:hover {
        background: linear-gradient(135deg, #FFE066 0%, #FFD700 50%, #E69D00 100%);
        box-shadow: 0 15px 35px rgba(255, 193, 7, 0.5), 0 0 25px rgba(255, 193, 7, 0.6);
        transform: translateY(-2px);
    }

    /* Floating Keyframe Animation */
    @keyframes floatHero {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-18px) rotate(1.5deg); }
    }

    @keyframes floatSlow {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    @keyframes pulseGlow {
        0%, 100% { opacity: 0.4; filter: blur(40px); }
        50% { opacity: 0.8; filter: blur(60px); }
    }

    .animate-float-hero {
        animation: floatHero 6s ease-in-out infinite;
    }

    .animate-float-slow {
        animation: floatSlow 5s ease-in-out infinite;
    }

    .animate-pulse-glow {
        animation: pulseGlow 4s ease-in-out infinite;
    }

    /* Golden bokeh particles background */
    .bg-particles {
        background-image: 
            radial-gradient(2px 2px at 20px 30px, #FFC107, rgba(0,0,0,0)),
            radial-gradient(2px 2px at 40px 70px, #FFD700, rgba(0,0,0,0)),
            radial-gradient(3px 3px at 50px 160px, #FF6B00, rgba(0,0,0,0)),
            radial-gradient(2px 2px at 90px 40px, #FFF, rgba(0,0,0,0)),
            radial-gradient(3px 3px at 130px 80px, #FFC107, rgba(0,0,0,0));
        background-repeat: repeat;
        background-size: 200px 200px;
    }
</style>

<div class="min-h-screen bg-[#081B2D] text-slate-100 overflow-hidden relative">

    <!-- Ambient Lighting & Glow Orbs background -->
    <div class="absolute top-0 left-1/4 w-[600px] h-[600px] bg-blue-600/20 rounded-full blur-[140px] pointer-events-none animate-pulse-glow"></div>
    <div class="absolute top-40 right-10 w-[500px] h-[500px] bg-amber-500/20 rounded-full blur-[130px] pointer-events-none animate-pulse-glow" style="animation-delay: 2s;"></div>
    <div class="absolute bottom-1/3 left-10 w-[600px] h-[600px] bg-orange-600/15 rounded-full blur-[150px] pointer-events-none"></div>

    <!-- MAIN 1920 CANVAS CONTAINER -->
    <div class="max-w-[1920px] mx-auto px-4 sm:px-8 lg:px-16 py-8 relative z-10">

        <!-- ==================================== -->
        <!-- HERO SECTION                         -->
        <!-- ==================================== -->
        <section class="relative rounded-3xl overflow-hidden glass-card border border-amber-500/30 p-8 lg:p-16 mb-20 bg-particles">
            <!-- Overlay background light streak -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#081B2D]/95 via-[#081B2D]/80 to-transparent z-0"></div>
            
            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Left Side: Large 3D Typography & CTA -->
                <div class="lg:col-span-6 space-y-8">
                    <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-amber-500/10 border border-amber-500/30 backdrop-blur-md">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-ping"></span>
                        <span class="text-xs font-extrabold uppercase tracking-widest text-amber-300">Apple-Quality 3D Showcase • 2026 Edition</span>
                    </div>

                    <h1 class="text-5xl sm:text-6xl xl:text-7xl font-black tracking-tight leading-none uppercase">
                        <span class="block text-white drop-shadow-md">EXPLORE OUR</span>
                        <span class="gold-gradient-text block mt-2 drop-shadow-[0_10px_20px_rgba(255,193,7,0.3)]">COLLECTIONS</span>
                    </h1>

                    <p class="text-lg xl:text-xl text-slate-300 max-w-xl font-light leading-relaxed">
                        Experience the finest collection of premium Sivakasi fireworks crafted for unforgettable celebrations with unmatched brilliance, safety, and grand aesthetics.
                    </p>

                    <div class="flex flex-wrap items-center gap-5 pt-4">
                        <a href="#category-grid" class="gold-gradient-btn text-slate-950 font-black px-8 py-4 rounded-2xl text-base flex items-center gap-3 transform active:scale-95 cursor-pointer">
                            <span>Explore Collection</span>
                            <i data-lucide="arrow-right" class="w-5 h-5"></i>
                        </a>
                        <a href="#special-features" class="px-8 py-4 rounded-2xl border border-slate-600 hover:border-amber-400 text-slate-200 hover:text-amber-300 font-bold transition backdrop-blur-md bg-white/5 flex items-center gap-2">
                            <i data-lucide="sparkles" class="w-5 h-5 text-amber-400"></i>
                            <span>Why Choose Us</span>
                        </a>
                    </div>

                    <!-- Quick Stats Badges -->
                    <div class="grid grid-cols-3 gap-4 pt-6 border-t border-slate-700/50 max-w-lg">
                        <div>
                            <span class="block text-2xl font-black gold-gradient-text">100%</span>
                            <span class="text-xs text-slate-400">Green Crackers</span>
                        </div>
                        <div>
                            <span class="block text-2xl font-black gold-gradient-text">Direct</span>
                            <span class="text-xs text-slate-400">From Sivakasi</span>
                        </div>
                        <div>
                            <span class="block text-2xl font-black gold-gradient-text">80% OFF</span>
                            <span class="text-xs text-slate-400">Wholesale Price</span>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Floating 3D Product Showcase Composition -->
                <div class="lg:col-span-6 relative flex items-center justify-center">
                    <div class="relative w-full max-w-2xl animate-float-hero">
                        <!-- Golden Glow Aura behind 3D render -->
                        <div class="absolute -inset-4 bg-gradient-to-tr from-amber-500/30 via-orange-500/20 to-blue-600/30 rounded-full blur-3xl opacity-80 z-0"></div>
                        
                        <!-- Photorealistic 3D composition render -->
                        <img src="{{ asset('images/3d/hero.png') }}" alt="SRI CRACKERS 3D Fireworks Collection" class="relative z-10 w-full h-auto object-contain drop-shadow-[0_25px_35px_rgba(0,0,0,0.8)] filter brightness-105 contrast-105">
                        
                        <!-- Floating Glass Floating Micro-Cards -->
                        <div class="absolute -top-4 -left-6 z-20 glass-card p-3 rounded-2xl flex items-center gap-3 animate-float-slow shadow-2xl border border-amber-400/50">
                            <div class="w-10 h-10 rounded-xl bg-amber-500/20 flex items-center justify-center text-amber-400">
                                <i data-lucide="package-check" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-white">Gift Packs & Combos</span>
                                <span class="block text-[10px] text-amber-300">Ready To Ship</span>
                            </div>
                        </div>

                        <div class="absolute -bottom-6 -right-6 z-20 glass-card p-3 rounded-2xl flex items-center gap-3 animate-float-slow shadow-2xl border border-amber-400/50" style="animation-delay: 2.5s;">
                            <div class="w-10 h-10 rounded-xl bg-orange-500/20 flex items-center justify-center text-orange-400">
                                <i data-lucide="flame" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-white">High Altitude Sky Shots</span>
                                <span class="block text-[10px] text-amber-300">240+ Shots Mortars</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- ==================================== -->
        <!-- CATEGORY SECTION                     -->
        <!-- ==================================== -->
        <section id="category-grid" class="mb-28 scroll-mt-24">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-400/10 border border-amber-400/30">
                    <i data-lucide="layers" class="w-4 h-4 text-amber-400"></i>
                    <span class="text-xs font-bold uppercase tracking-widest text-amber-400">Curated Collections</span>
                </div>
                <h2 class="text-4xl sm:text-5xl font-black text-white tracking-tight">
                    Shop By <span class="gold-gradient-text">Category</span>
                </h2>
                <p class="text-slate-300 text-base sm:text-lg font-light">
                    Explore our 10 signature 3D firework categories designed for ultimate celebration brilliance.
                </p>
            </div>

            <!-- 10 Premium 3D Category Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-8">
                @foreach($categoriesList as $cat)
                <div class="glass-card glass-card-interactive rounded-3xl p-6 flex flex-col justify-between group relative overflow-hidden">
                    <!-- Top Ribbon/Badge -->
                    <div class="flex items-center justify-between mb-4 z-10">
                        <span class="text-[11px] font-black uppercase tracking-wider px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-300">
                            {{ $cat['tag'] }}
                        </span>
                        <span class="text-xs font-bold text-slate-400">
                            {{ $cat['count'] }}
                        </span>
                    </div>

                    <!-- 3D Realistic Render Container -->
                    <div class="relative h-52 w-full my-3 flex items-center justify-center group-hover:scale-105 transition-transform duration-500 ease-out z-10">
                        <!-- Soft Ambient Reflection Glow -->
                        <div class="absolute inset-4 rounded-full bg-amber-500/15 blur-2xl group-hover:bg-amber-400/30 transition-all"></div>
                        <img src="{{ $cat['image'] }}" alt="{{ $cat['name'] }}" class="max-h-48 w-auto object-contain drop-shadow-[0_15px_20px_rgba(0,0,0,0.6)] filter brightness-105">
                    </div>

                    <!-- Category Content -->
                    <div class="space-y-3 pt-2 z-10">
                        <span class="text-xs font-bold text-amber-400 block">{{ $cat['badge'] }}</span>
                        <h3 class="text-xl font-bold text-white group-hover:text-amber-300 transition-colors">
                            {{ $cat['name'] }}
                        </h3>
                        <p class="text-xs text-slate-300 font-light line-clamp-2 leading-relaxed">
                            {{ $cat['description'] }}
                        </p>

                        <div class="pt-4">
                            <a href="#product-explorer" @click="$dispatch('filter-category', '{{ $cat['name'] }}')" class="w-full py-3 px-4 rounded-xl border border-amber-500/40 hover:border-amber-400 bg-amber-500/10 hover:bg-amber-400 hover:text-slate-950 font-bold text-xs flex items-center justify-center gap-2 transition-all duration-300 group-hover:shadow-[0_0_20px_rgba(255,193,7,0.4)]">
                                <span>Explore Category</span>
                                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>


        <!-- ==================================== -->
        <!-- SPECIAL SECTION                      -->
        <!-- ==================================== -->
        <section id="special-features" class="mb-28 scroll-mt-24">
            <div class="glass-card rounded-3xl p-8 lg:p-14 border border-amber-500/30 relative overflow-hidden bg-particles">
                <div class="text-center max-w-2xl mx-auto mb-14 space-y-3">
                    <span class="text-xs font-extrabold uppercase tracking-widest text-amber-400">The Sri Crackers Difference</span>
                    <h2 class="text-3xl sm:text-4xl font-black text-white">
                        Why Choose <span class="gold-gradient-text">SRI CRACKERS</span>
                    </h2>
                    <p class="text-slate-300 text-sm sm:text-base font-light">
                        Guaranteed safety, wholesale factory direct rates, and premium Sivakasi craftsmanship.
                    </p>
                </div>

                <!-- 4 Premium Floating Glass Cards with 3D Gold Finish Icons -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

                    <!-- Card 1 -->
                    <div class="glass-card p-8 rounded-2xl hover:border-amber-400 transition-all duration-300 hover:-translate-y-2 group text-center flex flex-col items-center">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-amber-600 via-amber-400 to-amber-200 p-[2px] mb-6 group-hover:scale-110 transition-transform">
                            <div class="w-full h-full bg-[#091D30] rounded-2xl flex items-center justify-center text-amber-300">
                                <i data-lucide="award" class="w-8 h-8"></i>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Premium Quality</h3>
                        <p class="text-xs text-slate-300 font-light leading-relaxed">
                            Handcrafted with top-tier pyrotechnic chemicals for vibrant color burst and maximum safety compliance.
                        </p>
                    </div>

                    <!-- Card 2 -->
                    <div class="glass-card p-8 rounded-2xl hover:border-amber-400 transition-all duration-300 hover:-translate-y-2 group text-center flex flex-col items-center">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-amber-600 via-amber-400 to-amber-200 p-[2px] mb-6 group-hover:scale-110 transition-transform">
                            <div class="w-full h-full bg-[#091D30] rounded-2xl flex items-center justify-center text-amber-300">
                                <i data-lucide="factory" class="w-8 h-8"></i>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Direct From Sivakasi</h3>
                        <p class="text-xs text-slate-300 font-light leading-relaxed">
                            Sourced straight from certified Sivakasi factories, eliminating middlemen for authentic quality.
                        </p>
                    </div>

                    <!-- Card 3 -->
                    <div class="glass-card p-8 rounded-2xl hover:border-amber-400 transition-all duration-300 hover:-translate-y-2 group text-center flex flex-col items-center">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-amber-600 via-amber-400 to-amber-200 p-[2px] mb-6 group-hover:scale-110 transition-transform">
                            <div class="w-full h-full bg-[#091D30] rounded-2xl flex items-center justify-center text-amber-300">
                                <i data-lucide="shield-check" class="w-8 h-8"></i>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Safe Celebration</h3>
                        <p class="text-xs text-slate-300 font-light leading-relaxed">
                            100% certified green crackers with reduced smoke emission and kid-friendly safety features.
                        </p>
                    </div>

                    <!-- Card 4 -->
                    <div class="glass-card p-8 rounded-2xl hover:border-amber-400 transition-all duration-300 hover:-translate-y-2 group text-center flex flex-col items-center">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-amber-600 via-amber-400 to-amber-200 p-[2px] mb-6 group-hover:scale-110 transition-transform">
                            <div class="w-full h-full bg-[#091D30] rounded-2xl flex items-center justify-center text-amber-300">
                                <i data-lucide="tags" class="w-8 h-8"></i>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Best Festival Prices</h3>
                        <p class="text-xs text-slate-300 font-light leading-relaxed">
                            Flat wholesale pricing with discounts up to 80% OFF on all festival and bulk family orders.
                        </p>
                    </div>

                </div>
            </div>
        </section>


        <!-- ==================================== -->
        <!-- LIVE PRODUCT EXPLORER & SEARCH       -->
        <!-- ==================================== -->
        <section id="product-explorer" class="scroll-mt-24" x-data="{
            search: '',
            selectedCategory: new URLSearchParams(location.search).get('category') || '',
            minPrice: '',
            maxPrice: '',
            allProducts: {{ json_encode($allProducts) }},
            
            init() {
                window.addEventListener('filter-category', (e) => {
                    this.selectedCategory = e.detail;
                });
            },

            get filteredProducts() {
                return this.allProducts.filter(p => {
                    const matchesSearch = p.name.toLowerCase().includes(this.search.toLowerCase());
                    const matchesCat = !this.selectedCategory || p.category.toLowerCase().includes(this.selectedCategory.toLowerCase());
                    const matchesMin = !this.minPrice || p.price >= parseInt(this.minPrice);
                    const matchesMax = !this.maxPrice || p.price <= parseInt(this.maxPrice);
                    return matchesSearch && matchesCat && matchesMin && matchesMax;
                });
            }
        }">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4 border-b border-slate-700/60 pb-6">
                <div>
                    <span class="text-xs font-bold text-amber-400 uppercase tracking-widest">Interactive Store Front</span>
                    <h2 class="text-3xl font-black text-white">Full Product Catalog</h2>
                </div>

                <!-- Live Search Box -->
                <div class="w-full md:w-80 relative">
                    <i data-lucide="search" class="w-4 h-4 absolute left-4 top-3.5 text-amber-400"></i>
                    <input type="text" x-model="search" placeholder="Search products..." class="w-full bg-[#0D243A] border border-amber-500/30 text-white text-sm rounded-xl pl-10 pr-4 py-2.5 outline-none focus:border-amber-400 transition">
                </div>
            </div>

            <!-- Category Pills Filter Bar -->
            <div class="flex items-center gap-3 overflow-x-auto pb-4 custom-scrollbar mb-8">
                <button @click="selectedCategory = ''" :class="!selectedCategory ? 'bg-amber-400 text-slate-950 font-black' : 'bg-[#0D243A] border border-slate-700 text-slate-300 hover:border-amber-400'" class="px-5 py-2 rounded-xl text-xs uppercase tracking-wider transition whitespace-nowrap">
                    All Products
                </button>
                @foreach($categories as $cat)
                <button @click="selectedCategory = '{{ $cat }}'" :class="selectedCategory === '{{ $cat }}' ? 'bg-amber-400 text-slate-950 font-black' : 'bg-[#0D243A] border border-slate-700 text-slate-300 hover:border-amber-400'" class="px-5 py-2 rounded-xl text-xs uppercase tracking-wider transition whitespace-nowrap">
                    {{ $cat }}
                </button>
                @endforeach
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" x-show="filteredProducts.length > 0">
                <template x-for="product in filteredProducts" :key="product.id">
                    <div class="glass-card rounded-2xl overflow-hidden hover:border-amber-400 transition-all duration-300 flex flex-col justify-between group">
                        <div class="h-48 bg-[#071727] relative flex items-center justify-center p-4">
                            <template x-if="product.image_path">
                                <img :src="'/storage/' + product.image_path" :alt="product.name" class="max-h-36 w-auto object-contain group-hover:scale-105 transition-transform duration-300">
                            </template>
                            <template x-if="!product.image_path">
                                <span class="text-4xl" x-text="product.image_icon"></span>
                            </template>

                            <span x-show="product.discount" class="absolute top-3 right-3 bg-red-600 text-white font-extrabold text-[10px] px-2.5 py-0.5 rounded-full shadow-lg" x-text="product.discount + ' OFF'"></span>
                        </div>

                        <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                            <div>
                                <span class="text-[10px] uppercase font-bold text-amber-400 tracking-wider block" x-text="product.category"></span>
                                <h4 class="font-bold text-white text-base leading-snug line-clamp-1" x-text="product.name"></h4>
                                
                                <div class="flex items-baseline gap-2 mt-2">
                                    <span class="text-xl font-black gold-gradient-text" x-text="'₹' + product.price.toLocaleString()"></span>
                                    <span x-show="product.original_price" class="text-xs text-slate-400 line-through" x-text="'₹' + product.original_price?.toLocaleString()"></span>
                                </div>
                            </div>

                            <button @click="addToCart(product)" class="w-full gold-gradient-btn text-slate-950 font-bold py-2.5 rounded-xl text-xs uppercase tracking-wider flex items-center justify-center gap-2 active:scale-95">
                                <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                                <span>Add To Cart</span>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Empty State -->
            <div x-show="filteredProducts.length === 0" class="glass-card rounded-2xl p-12 text-center" x-cloak>
                <i data-lucide="package-x" class="w-12 h-12 text-amber-400 mx-auto mb-4"></i>
                <h3 class="text-lg font-bold text-white mb-2">No products match your filters</h3>
                <button @click="search = ''; selectedCategory = ''" class="text-amber-400 font-bold text-sm underline hover:text-amber-300">Clear Search & Filters</button>
            </div>
        </section>

    </div>
</div>
@endsection
