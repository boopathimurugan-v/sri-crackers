<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sri Crackers - Homepage</title>
  
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  
  <!-- React & ReactDOM CDN -->
  <script crossorigin src="https://unpkg.com/react@18/umd/react.development.js"></script>
  <script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
  
  <!-- Babel CDN for JSX -->
  <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
  
  <!-- Lucide Icons CDN -->
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-amber-50/30 text-slate-800 font-sans">

  <div id="root"></div>

  <script type="text/babel">
    const { useState, useEffect } = React;

    function SriCrackersHomepage() {
      const [isMenuOpen, setIsMenuOpen] = useState(false);

      useEffect(() => {
        if (window.lucide) {
          window.lucide.createIcons();
        }
      }, [isMenuOpen]);

      const categories = [
        { name: 'Sparklers & Flower Pots', count: '25+ Items', image: '✨' },
        { name: 'Sound Crackers', count: '15+ Items', image: '💥' },
        { name: 'Fancy Aerial Shots', count: '30+ Items', image: '🚀' },
        { name: 'Kids Special & Novelties', count: '20+ Items', image: '🎁' },
        { name: 'Family Combo Boxes', count: '5 Packages', image: '📦' },
      ];

      const featuredProducts = [
        { name: '12 Shot Sky Fountain', category: 'Aerial Shots', price: '₹450', originalPrice: '₹900', discount: '50% OFF' },
        { name: 'Electric Sparklers (15cm)', category: 'Sparklers', price: '₹120', originalPrice: '₹240', discount: '50% OFF' },
        { name: 'Mega Family Gift Box', category: 'Combo Packs', price: '₹2,499', originalPrice: '₹5,000', discount: '50% OFF' },
        { name: 'Peacock Flower Pots', category: 'Flower Pots', price: '₹280', originalPrice: '₹560', discount: '50% OFF' },
      ];

      return (
        <div className="min-h-screen">
          {/* Top Banner */}
          <div className="bg-gradient-to-r from-red-600 to-amber-600 text-white text-xs md:text-sm py-2 px-4 text-center font-medium">
            💥 Festive Special Offer: Get Up to <span className="font-bold underline">80% OFF</span> on Direct Factory Bookings! 💥
          </div>

          {/* Navigation */}
          <header className="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-amber-100 shadow-sm">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
              
              {/* Logo */}
              <div className="flex items-center gap-2">
                <div className="bg-red-600 text-amber-300 p-2 rounded-xl shadow-md font-black text-xl">
                  SRI
                </div>
                <div>
                  <span className="text-2xl font-black tracking-tight text-red-600 block leading-none">
                    SRI CRACKERS
                  </span>
                  <span className="text-[10px] tracking-widest text-amber-600 font-bold uppercase">
                    Sivakasi Direct Quality
                  </span>
                </div>
              </div>

              {/* Desktop Nav */}
              <nav className="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-700">
                <a href="#home" className="text-red-600 hover:text-red-700">Home</a>
                <a href="#categories" className="hover:text-red-600 transition">Categories</a>
                <a href="#combos" className="hover:text-red-600 transition">Combo Offers</a>
                <a href="#pricelist" className="hover:text-red-600 transition">Price List</a>
                <a href="#about" className="hover:text-red-600 transition">About Us</a>
              </nav>

              {/* Right Actions */}
              <div className="hidden md:flex items-center gap-4">
                <button className="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                  <i data-lucide="search" className="w-4 h-4"></i> Search
                </button>
                <button className="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl font-bold shadow-md shadow-red-200 transition">
                  <i data-lucide="shopping-cart" className="w-4 h-4"></i> Cart (0)
                </button>
              </div>

              {/* Mobile Menu Button */}
              <button className="md:hidden text-slate-700" onClick={() => setIsMenuOpen(!isMenuOpen)}>
                <i data-lucide={isMenuOpen ? "x" : "menu"}></i>
              </button>
            </div>

            {/* Mobile Dropdown */}
            {isMenuOpen && (
              <div className="md:hidden bg-white border-b border-amber-100 px-4 pt-2 pb-6 space-y-3 font-medium">
                <a href="#home" className="block text-red-600">Home</a>
                <a href="#categories" className="block text-slate-600">Categories</a>
                <a href="#combos" className="block text-slate-600">Combo Offers</a>
                <a href="#pricelist" className="block text-slate-600">Price List</a>
                <button className="w-full flex items-center justify-center gap-2 bg-red-600 text-white py-2.5 rounded-xl font-bold">
                  <i data-lucide="shopping-cart" className="w-4 h-4"></i> Quick Order
                </button>
              </div>
            )}
          </header>

          {/* Hero Section */}
          <section className="relative overflow-hidden bg-gradient-to-b from-amber-100/60 via-amber-50/20 to-white pt-12 pb-20">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
              <div className="grid lg:grid-cols-2 gap-12 items-center">
                
                {/* Left Content */}
                <div className="space-y-6 text-center lg:text-left">
                  <div className="inline-flex items-center gap-2 bg-amber-100 border border-amber-300 text-amber-800 text-xs font-bold px-3 py-1.5 rounded-full">
                    <i data-lucide="sparkles" className="w-3.5 h-3.5 text-amber-600"></i> 100% Safe & Certified Green Crackers
                  </div>
                  <h1 className="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Brighten Your Celebrations with <span className="text-red-600">Sri Crackers</span>
                  </h1>
                  <p className="text-lg text-slate-600 max-w-xl mx-auto lg:mx-0">
                    Directly sourced from Sivakasi. Premium quality, best market prices, and safe   delivery for all your festive occasions.
                  </p>
                  
                  <div className="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start pt-2">
                    <a href="#pricelist" className="bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-3.5 rounded-xl shadow-lg shadow-red-200 transition text-center">
                      Download Price List
                    </a>
                    <a href="#combos" className="bg-white hover:bg-slate-50 text-slate-800 border border-slate-200 font-bold px-8 py-3.5 rounded-xl shadow-sm transition text-center">
                      View Combo Packs
                    </a>
                  </div>

                  {/* Quick Trust Badges */}
                  <div className="grid grid-cols-3 gap-4 pt-6 border-t border-amber-200/60">
                    <div>
                      <h4 className="font-extrabold text-slate-900 text-lg">100%</h4>
                      <p className="text-xs text-slate-500">Original Sivakasi</p>
                    </div>
                    <div>
                      <h4 className="font-extrabold text-slate-900 text-lg">80% OFF</h4>
                      <p className="text-xs text-slate-500">Factory Discount</p>
                    </div>
                    <div>
                      <h4 className="font-extrabold text-slate-900 text-lg">Safe</h4>
                      <p className="text-xs text-slate-500">Green Crackers</p>
                    </div>
                  </div>
                </div>

                {/* Right Visual Card */}
                <div className="relative">
                  <div className="bg-gradient-to-tr from-red-600 to-amber-500 p-8 rounded-3xl shadow-2xl text-white relative z-10 overflow-hidden">
                    <div className="absolute top-0 right-0 opacity-10 text-9xl font-black">✨</div>
                    <span className="bg-amber-300 text-red-950 font-black text-xs px-3 py-1 rounded-full uppercase tracking-wider">
                      Bestseller Package
                    </span>
                    <h3 className="text-3xl font-extrabold mt-4 mb-2">Mega Family Cracker Box</h3>
                    <p className="text-amber-100 text-sm mb-6">45 Premium Crackers items included for complete family entertainment.</p>
                    <div className="flex items-baseline gap-3 mb-6">
                      <span className="text-4xl font-black">₹2,499</span>
                      <span className="text-amber-200 line-through text-lg">₹5,000</span>
                    </div>
                    <button className="w-full bg-white text-red-600 font-black py-3.5 rounded-xl hover:bg-amber-50 shadow-md transition">
                      Order Combo Pack Now
                    </button>
                  </div>
                </div>

              </div>
            </div>
          </section>

          {/* Features Bar */}
          <section className="bg-white border-y border-slate-100 py-8">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
              <div className="flex items-center gap-4 p-4 rounded-xl bg-amber-50/50 border border-amber-100">
                <i data-lucide="shield-check" className="w-8 h-8 text-red-600"></i>
                <div>
                  <h5 className="font-bold text-slate-800">Certified Quality</h5>
                  <p className="text-xs text-slate-500">100% Eco-friendly green crackers</p>
                </div>
              </div>
              <div className="flex items-center gap-4 p-4 rounded-xl bg-amber-50/50 border border-amber-100">
                <i data-lucide="truck" className="w-8 h-8 text-red-600"></i>
                <div>
                  <h5 className="font-bold text-slate-800">Prompt Transport</h5>
                  <p className="text-xs text-slate-500">Delivered directly from factory hubs</p>
                </div>
              </div>
              <div className="flex items-center gap-4 p-4 rounded-xl bg-amber-50/50 border border-amber-100">
                <i data-lucide="phone" className="w-8 h-8 text-red-600"></i>
                <div>
                  <h5 className="font-bold text-slate-800">Direct Support</h5>
                  <p className="text-xs text-slate-500">Instant WhatsApp & phone ordering</p>
                </div>
              </div>
            </div>
          </section>

          {/* Categories Grid */}
          <section id="categories" className="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center mb-12">
              <h2 className="text-3xl font-extrabold text-slate-900">Explore Categories</h2>
              <p className="text-slate-500 text-sm mt-2">Choose from our wide variety of Sivakasi crackers</p>
            </div>

            <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
              {categories.map((cat, idx) => (
                <div key={idx} className="bg-white p-6 rounded-2xl border border-slate-100 hover:border-amber-300 hover:shadow-lg transition text-center group cursor-pointer">
                  <div className="text-4xl mb-3 group-hover:scale-110 transition transform">{cat.image}</div>
                  <h4 className="font-bold text-slate-800 text-sm group-hover:text-red-600 transition">{cat.name}</h4>
                  <p className="text-xs text-slate-400 mt-1">{cat.count}</p>
                </div>
              ))}
            </div>
          </section>

          {/* Featured Products */}
          <section className="py-16 bg-slate-50/50 border-t border-slate-100">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
              <div className="flex justify-between items-end mb-10">
                <div>
                  <h2 className="text-3xl font-extrabold text-slate-900">Top Trending Crackers</h2>
                  <p className="text-slate-500 text-sm mt-1">Most popular picks for this festival season</p>
                </div>
                <a href="#pricelist" className="text-red-600 font-bold text-sm hover:underline">View All Products →</a>
              </div>

              <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {featuredProducts.map((prod, idx) => (
                  <div key={idx} className="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-md transition">
                    <div className="h-44 bg-amber-100/40 flex items-center justify-center text-5xl relative">
                      🎆
                      <span className="absolute top-3 right-3 bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                        {prod.discount}
                      </span>
                    </div>
                    <div className="p-5">
                      <span className="text-[10px] uppercase font-bold tracking-wider text-amber-600">{prod.category}</span>
                      <h4 className="font-bold text-slate-800 text-base mt-1">{prod.name}</h4>
                      <div className="flex items-baseline gap-2 mt-3">
                        <span className="text-xl font-extrabold text-slate-900">{prod.price}</span>
                        <span className="text-xs text-slate-400 line-through">{prod.originalPrice}</span>
                      </div>
                      <button className="w-full mt-4 bg-amber-50 hover:bg-red-600 hover:text-white text-red-600 font-bold py-2.5 rounded-xl border border-amber-200 hover:border-transparent transition text-sm">
                        Add to Quick Order
                      </button>
                    </div>
                  </div>
                ))}
              </div>
            </div>
          </section>

          {/* Footer */}
          <footer className="bg-slate-900 text-slate-300 py-12 border-t border-slate-800">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">
              <div>
                <div className="flex items-center gap-2 mb-4">
                  <div className="bg-red-600 text-amber-300 px-2 py-1 rounded-lg font-black text-lg">SRI</div>
                  <span className="text-xl font-black text-white tracking-tight">SRI CRACKERS</span>
                </div>
                <p className="text-xs text-slate-400 leading-relaxed">
                  Your trusted partner for authentic, safe, and high-quality Sivakasi crackers at wholesale prices.
                </p>
              </div>
              <div>
                <h5 className="text-white font-bold text-sm mb-3">Quick Links</h5>
                <ul className="space-y-2 text-xs">
                  <li><a href="#about" className="hover:text-amber-400">About Us</a></li>
                  <li><a href="#pricelist" className="hover:text-amber-400">Download Price List</a></li>
                  <li><a href="#combos" className="hover:text-amber-400">Combo Packages</a></li>
                  <li><a href="#contact" className="hover:text-amber-400">Contact Us</a></li>
                </ul>
              </div>
              <div>
                <h5 className="text-white font-bold text-sm mb-3">Contact Information</h5>
                <p className="text-xs text-slate-400 leading-relaxed">
                  Sivakasi Main Road,<br />
                  Tamil Nadu, India<br />
                  <strong>Phone:</strong> +91 98765 43210<br />
                  <strong>Email:</strong> info@sricrackers.com
                </p>
              </div>
              <div>
                <h5 className="text-white font-bold text-sm mb-3">Safety First</h5>
                <p className="text-xs text-slate-400 leading-relaxed">
                  We exclusively supply 100% eco-friendly green crackers manufactured under strict quality standards.
                </p>
              </div>
            </div>
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-6 border-t border-slate-800 text-center text-xs text-slate-500">
              © {new Date().getFullYear()} Sri Crackers. All rights reserved.
            </div>
          </footer>
        </div>
      );
    }

    const root = ReactDOM.createRoot(document.getElementById('root'));
    root.render(<SriCrackersHomepage />);
  </script>
</body>
</html>