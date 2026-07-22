<header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-amber-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
        
        {!! '<!-- Logo -->' !!}
        <div class="flex items-center gap-3">
            @if(isset($globalSettings) && $globalSettings->logo)
                <img src="{{ Storage::url('settings/' . $globalSettings->logo) }}" alt="Logo" class="h-10 rounded shadow-sm bg-white p-1">
            @else
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-red-700 shadow-sm">
                    <i data-lucide="sparkles" class="w-6 h-6"></i>
                </div>
            @endif
            <div>
                <span class="text-xl font-black tracking-wide text-red-600 uppercase block leading-none">
                    {{ isset($globalSettings) && $globalSettings->website_name ? $globalSettings->website_name : 'Sri Crackers' }}
                </span>
                <span class="text-[10px] tracking-widest text-amber-600 font-bold uppercase">
                    Sivakasi Direct Quality
                </span>
            </div>
        </div>

        {!! '<!-- Desktop Nav -->' !!}
        <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-700">
            <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'text-red-600' : 'hover:text-red-600 transition' }}">Home</a>
            <a href="{{ url('/categories') }}" class="{{ request()->is('categories') ? 'text-red-600' : 'hover:text-red-600 transition' }}">Categories</a>
            <a href="{{ url('/combos') }}" class="{{ request()->is('combos') ? 'text-red-600' : 'hover:text-red-600 transition' }}">Combo Offers</a>
            <a href="{{ url('/price-list') }}" class="{{ request()->is('price-list') ? 'text-red-600' : 'hover:text-red-600 transition' }}">Price List</a>
            <a href="{{ url('/about') }}" class="{{ request()->is('about') ? 'text-red-600' : 'hover:text-red-600 transition' }}">About Us</a>
            <a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'text-red-600' : 'hover:text-red-600 transition' }}">Contact</a>
        </nav>

        {!! '<!-- Right Actions -->' !!}
        <div class="hidden md:flex items-center gap-4">
            <button class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                <i data-lucide="search" class="w-4 h-4"></i> Search
            </button>
            
            @auth
                <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                    <i data-lucide="user" class="w-4 h-4"></i> Account
                </a>
            @else
                <a href="{{ route('login') }}" class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                    <i data-lucide="user" class="w-4 h-4"></i> Login
                </a>
            @endauth

            <button @click="isCartOpen = true" class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl font-bold shadow-md shadow-red-200 transition">
                <i data-lucide="shopping-cart" class="w-4 h-4"></i> Cart (<span x-text="cartCount"></span>)
            </button>
        </div>

        {!! '<!-- Mobile Menu Button -->' !!}
        <button class="md:hidden text-slate-700" @click="isMenuOpen = !isMenuOpen">
            <i data-lucide="menu" x-show="!isMenuOpen"></i>
            <i data-lucide="x" x-show="isMenuOpen" x-cloak></i>
        </button>
    </div>

    {!! '<!-- Mobile Dropdown -->' !!}
    <div x-show="isMenuOpen" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden bg-white border-b border-amber-100 px-4 pt-2 pb-6 space-y-3 font-medium absolute w-full shadow-lg">
        <a href="{{ url('/') }}" class="block {{ request()->is('/') ? 'text-red-600' : 'text-slate-600' }}">Home</a>
        <a href="{{ url('/categories') }}" class="block {{ request()->is('categories') ? 'text-red-600' : 'text-slate-600' }}">Categories</a>
        <a href="{{ url('/combos') }}" class="block {{ request()->is('combos') ? 'text-red-600' : 'text-slate-600' }}">Combo Offers</a>
        <a href="{{ url('/price-list') }}" class="block {{ request()->is('price-list') ? 'text-red-600' : 'text-slate-600' }}">Price List</a>
        <a href="{{ url('/about') }}" class="block {{ request()->is('about') ? 'text-red-600' : 'text-slate-600' }}">About Us</a>
        <a href="{{ url('/contact') }}" class="block {{ request()->is('contact') ? 'text-red-600' : 'text-slate-600' }}">Contact</a>
        
        @auth
            <a href="{{ route('customer.dashboard') }}" class="block text-slate-600 border-t border-slate-100 pt-3 mt-3">My Account</a>
        @else
            <a href="{{ route('login') }}" class="block text-slate-600 border-t border-slate-100 pt-3 mt-3">Login / Register</a>
        @endauth

        <button @click="isCartOpen = true; isMenuOpen = false" class="w-full flex items-center justify-center gap-2 bg-red-600 text-white py-2.5 rounded-xl font-bold mt-4">
            <i data-lucide="shopping-cart" class="w-4 h-4"></i> View Cart (<span x-text="cartCount"></span>)
        </button>
    </div>
</header>

<style>
    [x-cloak] { display: none !important; }
</style>
