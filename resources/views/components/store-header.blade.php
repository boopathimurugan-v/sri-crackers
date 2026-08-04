<header class="bg-white">
    <!-- Top Announcement Bar -->
    @if(isset($settings) && isset($settings['announcement_text']))
        <div class="bg-[#910A67] text-white text-center text-xs sm:text-sm py-2 font-semibold">
            {{ $settings['announcement_text'] }}
        </div>
    @endif

    <!-- Main Header -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex flex-wrap items-center justify-between gap-4">
            
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ url('/') }}">
                    @if(isset($settings) && isset($settings['logo_url']))
                        <img src="{{ $settings['logo_url'] }}" alt="Logo" class="h-12 md:h-16">
                    @else
                        <span class="text-2xl font-black text-[#910A67] uppercase">{{ isset($settings['website_name']) ? $settings['website_name'] : 'SRI CRACKERS' }}</span>
                    @endif
                </a>
            </div>

            <!-- Search Bar (Middle) -->
            <div class="flex-1 max-w-2xl hidden md:flex items-center mx-8">
                <div class="relative w-full">
                    <input type="text" placeholder="Search for products..." class="w-full pl-4 pr-12 py-3 rounded-full border-2 border-gray-200 focus:border-[#910A67] focus:ring-0 outline-none transition-colors text-sm font-medium text-gray-700">
                    <button class="absolute right-0 top-0 h-full px-5 bg-[#FFC000] rounded-r-full text-slate-900 hover:bg-[#e5ac00] transition-colors">
                        <i data-lucide="search" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            <!-- Right Actions -->
            <div class="flex items-center gap-6">
                <div class="hidden lg:flex flex-col text-right">
                    <span class="text-[#910A67] font-black text-lg">{{ isset($settings['phone']) ? $settings['phone'] : '+91 00000 00000' }}</span>
                    <span class="text-xs text-gray-500 font-bold uppercase tracking-wider">Customer Support</span>
                </div>

                <div class="flex items-center gap-4">
                    <button @click="isCartOpen = true" class="relative bg-[#910A67] hover:bg-[#7a0856] text-white p-3 rounded-xl transition shadow-lg shadow-pink-900/20">
                        <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                        <span x-text="cartCount" class="absolute -top-2 -right-2 bg-[#FFC000] text-slate-900 text-xs font-black w-6 h-6 flex items-center justify-center rounded-full border-2 border-white shadow-sm">0</span>
                    </button>
                    
                    <button class="md:hidden text-slate-700" @click="isMenuOpen = !isMenuOpen">
                        <i data-lucide="menu" x-show="!isMenuOpen"></i>
                        <i data-lucide="x" x-show="isMenuOpen" x-cloak></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Search (Visible only on small screens) -->
        <div class="mt-4 md:hidden relative w-full">
            <input type="text" placeholder="Search..." class="w-full pl-4 pr-12 py-2.5 rounded-full border border-gray-200 focus:border-[#910A67] outline-none text-sm font-medium">
            <button class="absolute right-0 top-0 h-full px-4 bg-[#FFC000] rounded-r-full text-slate-900">
                <i data-lucide="search" class="w-4 h-4"></i>
            </button>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="bg-[#910A67] text-white hidden md:block">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <ul class="flex items-center justify-center gap-8 py-3 text-sm font-bold uppercase tracking-wider">
                <li><a href="{{ url('/') }}" class="hover:text-[#FFC000] transition {{ request()->is('/') ? 'text-[#FFC000]' : '' }}">Home</a></li>
                <li><a href="{{ url('/categories') }}" class="hover:text-[#FFC000] transition {{ request()->is('categories') ? 'text-[#FFC000]' : '' }}">Category</a></li>
                <li><a href="{{ url('/price-list') }}" class="hover:text-[#FFC000] transition flex items-center gap-2"><i data-lucide="download" class="w-4 h-4"></i> Price List</a></li>
                <li><a href="{{ url('/about') }}" class="hover:text-[#FFC000] transition {{ request()->is('about') ? 'text-[#FFC000]' : '' }}">About Us</a></li>
                <li><a href="{{ url('/contact') }}" class="hover:text-[#FFC000] transition {{ request()->is('contact') ? 'text-[#FFC000]' : '' }}">Contact Us</a></li>
            </ul>
        </div>
    </nav>

    <!-- Mobile Menu Dropdown -->
    <div x-show="isMenuOpen" x-cloak class="md:hidden bg-[#910A67] text-white absolute w-full z-50 shadow-xl border-t border-pink-800">
        <ul class="flex flex-col text-sm font-bold uppercase tracking-wider divide-y divide-pink-800/50">
            <li><a href="{{ url('/') }}" class="block px-6 py-4 hover:bg-pink-900">Home</a></li>
            <li><a href="{{ url('/categories') }}" class="block px-6 py-4 hover:bg-pink-900">Category</a></li>
            <li><a href="{{ url('/price-list') }}" class="block px-6 py-4 hover:bg-pink-900 flex items-center gap-2"><i data-lucide="download" class="w-4 h-4"></i> Price List</a></li>
            <li><a href="{{ url('/about') }}" class="block px-6 py-4 hover:bg-pink-900">About Us</a></li>
            <li><a href="{{ url('/contact') }}" class="block px-6 py-4 hover:bg-pink-900">Contact Us</a></li>
        </ul>
    </div>
</header>
