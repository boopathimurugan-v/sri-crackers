<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @php
        $siteName = isset($globalSettings) && $globalSettings->website_name ? $globalSettings->website_name : 'Sri Crackers';
        $metaTitle = isset($globalSettings) && $globalSettings->meta_title ? $globalSettings->meta_title : $siteName;
        $metaDesc = isset($globalSettings) && $globalSettings->meta_description ? $globalSettings->meta_description : 'Buy premium quality fireworks online at wholesale prices.';
        $metaKeywords = isset($globalSettings) && $globalSettings->meta_keywords ? $globalSettings->meta_keywords : 'fireworks, crackers, sivakasi crackers, buy fireworks online';
        $ogImage = isset($globalSettings) && $globalSettings->og_image ? Storage::url('settings/' . $globalSettings->og_image) : asset('images/default-og.jpg');
        $pageTitle = View::hasSection('title') ? View::getSection('title') . ' - ' . $siteName : $metaTitle;
    @endphp

    <title>{{ $pageTitle }}</title>
    
    <meta name="description" content="{{ $metaDesc }}">
    <meta name="keywords" content="{{ $metaKeywords }}">
    <link rel="canonical" href="{{ url()->current() }}">

    {!! '<!-- Open Graph / Facebook -->' !!}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $metaDesc }}">
    <meta property="og:image" content="{{ url($ogImage) }}">

    {!! '<!-- Twitter -->' !!}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $metaDesc }}">
    <meta name="twitter:image" content="{{ url($ogImage) }}">

    {!! '<!-- Schema.org JSON-LD -->' !!}
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@type": "Organization",
      "name": "{{ $siteName }}",
      "url": "{{ url('/') }}",
      "logo": "{{ isset($globalSettings) && $globalSettings->logo ? url(Storage::url('settings/' . $globalSettings->logo)) : '' }}",
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "{{ isset($globalSettings) && $globalSettings->phone ? $globalSettings->phone : '' }}",
        "contactType": "customer service"
      }
    }
    </script>
    
    @if(isset($globalSettings) && $globalSettings->favicon)
        <link rel="icon" href="{{ Storage::url('settings/' . $globalSettings->favicon) }}">
    @endif
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-amber-50/30 text-slate-800 font-sans" 
      x-data="{ 
          isMenuOpen: false, 
          isCartOpen: false,
          cart: JSON.parse(localStorage.getItem('cart') || '[]'),
          saveCart() {
              localStorage.setItem('cart', JSON.stringify(this.cart));
          },
          clearCart() {
              this.cart = [];
              this.saveCart();
          },
          addToCart(product) {
              const existing = this.cart.find(item => item.name === product.name);
              if (existing) {
                  existing.quantity += 1;
              } else {
                  this.cart.push({ ...product, quantity: 1 });
              }
              this.saveCart();
              this.isCartOpen = true;
          },
          removeFromCart(index) {
              this.cart.splice(index, 1);
              this.saveCart();
          },
          updateQuantity(index, amount) {
              if (this.cart[index].quantity + amount > 0) {
                  this.cart[index].quantity += amount;
              } else {
                  this.removeFromCart(index);
              }
              this.saveCart();
          },
          get cartTotal() {
              return this.cart.reduce((total, item) => total + (item.price * item.quantity), 0);
          },
          get cartCount() {
              return this.cart.reduce((count, item) => count + item.quantity, 0);
          }
      }">

    @include('components.store-header')
    
    <main class="min-h-screen">
        @yield('content')
    </main>

    @include('components.store-footer')
    
    @include('components.cart-sidebar')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
        
        // Re-initialize lucide icons when Alpine DOM updates
        document.addEventListener('alpine:initialized', () => {
             lucide.createIcons();
        });
    </script>
</body>
</html>
