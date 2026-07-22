<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard - @yield('title')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-amber-50/30 text-slate-800 font-sans min-h-screen flex flex-col">

    @include('components.store-header')

    <div class="flex-grow bg-slate-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row gap-8">
                
                {!! '<!-- Sidebar -->' !!}
                <div class="w-full md:w-64 shrink-0">
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden sticky top-24">
                        <div class="p-6 bg-slate-900 text-white text-center">
                            <div class="w-16 h-16 bg-red-600 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl font-bold border-2 border-white/20">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <h3 class="font-bold truncate">{{ auth()->user()->name }}</h3>
                            <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        
                        <nav class="p-2 space-y-1">
                            <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('customer.dashboard') ? 'bg-red-50 text-red-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Dashboard
                            </a>
                            <a href="{{ route('customer.profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('customer.profile', 'customer.password') ? 'bg-red-50 text-red-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                <i data-lucide="user" class="w-5 h-5"></i> Profile
                            </a>
                            <a href="{{ route('customer.addresses.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('customer.addresses.*') ? 'bg-red-50 text-red-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                <i data-lucide="map-pin" class="w-5 h-5"></i> Addresses
                            </a>
                            <a href="{{ route('customer.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('customer.orders.*') ? 'bg-red-50 text-red-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                <i data-lucide="shopping-bag" class="w-5 h-5"></i> Orders
                            </a>
                            <a href="{{ route('customer.wishlist.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('customer.wishlist.*') ? 'bg-red-50 text-red-600 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                <i data-lucide="heart" class="w-5 h-5"></i> Wishlist
                            </a>
                            <hr class="my-2 border-slate-100">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-red-50 hover:text-red-600 transition text-left">
                                    <i data-lucide="log-out" class="w-5 h-5"></i> Logout
                                </button>
                            </form>
                        </nav>
                    </div>
                </div>

                {!! '<!-- Main Content -->' !!}
                <div class="flex-1">
                    @if(session('success'))
                        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-2">
                            <i data-lucide="check-circle" class="w-5 h-5 shrink-0"></i>
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-2">
                            <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    @yield('customer_content')
                </div>

            </div>
        </div>
    </div>

    @include('components.store-footer')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
</body>
</html>
