<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @php
        $siteName = isset($globalSettings) && $globalSettings->website_name ? $globalSettings->website_name : 'SRI CRACKERS';
        $metaTitle = isset($globalSettings) && $globalSettings->meta_title ? $globalSettings->meta_title : 'SRI CRACKERS | Premium Sivakasi Fireworks';
        $metaDesc = isset($globalSettings) && $globalSettings->meta_description ? $globalSettings->meta_description : 'Buy Premium Sivakasi Crackers Online from SRI CRACKERS with the Best Festival Prices, Safe Packaging, and Fast Delivery.';
        $metaKeywords = isset($globalSettings) && $globalSettings->meta_keywords ? $globalSettings->meta_keywords : 'SRI CRACKERS, Sivakasi Crackers, Green Crackers, Buy Crackers Online, Sivakasi Fireworks';
        $ogImage = isset($globalSettings) && $globalSettings->og_image ? Storage::url('settings/' . $globalSettings->og_image) : asset('images/default-og.jpg');
        $pageTitle = View::hasSection('title') ? View::getSection('title') . ' | ' . $siteName : $metaTitle;
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
<body class="bg-gray-50 text-slate-800 font-sans" x-data="crackerStore()" data-gst-enabled="{{ isset($globalSettings) && $globalSettings->gst_enabled ? 'true' : 'false' }}" data-gst-percentage="{{ isset($globalSettings) ? $globalSettings->gst_percentage : 0 }}">

    <script>
        function crackerStore() {
            return {
                isMenuOpen: false,
                isCartOpen: false,
                cart: JSON.parse(localStorage.getItem('cracker_cart') || '[]'),
                gstEnabled: document.body.dataset.gstEnabled === 'true',
                gstPercentage: parseFloat(document.body.dataset.gstPercentage || 0),
                
                saveCart() {
                    localStorage.setItem('cracker_cart', JSON.stringify(this.cart));
                },
                
                getQty(productId) {
                    const item = this.cart.find(i => i.id === productId);
                    return item ? item.quantity : 0;
                },
                
                updateQty(product, amount) {
                    const index = this.cart.findIndex(i => i.id === product.id);
                    if (index > -1) {
                        const newQty = this.cart[index].quantity + amount;
                        if (newQty > 0) {
                            this.cart[index].quantity = newQty;
                        } else {
                            this.cart.splice(index, 1);
                        }
                    } else if (amount > 0) {
                        this.cart.push({
                            id: product.id,
                            name: product.name,
                            image: product.main_image || product.image_path,
                            mrp: parseFloat(product.mrp),
                            price: parseFloat(product.offer_price),
                            quantity: amount
                        });
                    }
                    this.saveCart();
                },
                
                get cartCount() {
                    return this.cart.reduce((count, item) => count + item.quantity, 0);
                },
                
                get totalMrp() {
                    return this.cart.reduce((total, item) => total + (item.mrp * item.quantity), 0);
                },
                
                get totalPayable() {
                    return this.cart.reduce((total, item) => total + (item.price * item.quantity), 0);
                },
                
                get totalSavings() {
                    return this.totalMrp - this.totalPayable;
                },
                
                get totalGst() {
                    if (this.gstEnabled) {
                        return (this.totalPayable * this.gstPercentage) / 100;
                    }
                    return 0;
                },
                
                get finalPayable() {
                    return this.totalPayable + this.totalGst;
                }
            }
        }
    </script>

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
