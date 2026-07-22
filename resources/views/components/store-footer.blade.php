<footer class="bg-slate-900 text-slate-300 py-12 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
            <div class="flex items-center gap-3 mb-4">
                @if(isset($globalSettings) && $globalSettings->logo)
                    <img src="{{ Storage::url('settings/' . $globalSettings->logo) }}" alt="Logo" class="h-10 rounded shadow-sm bg-white p-1">
                @else
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-red-700 shadow-sm">
                        <i data-lucide="sparkles" class="w-6 h-6"></i>
                    </div>
                @endif
                <span class="text-xl font-black text-white tracking-wide uppercase">{{ isset($globalSettings) && $globalSettings->website_name ? $globalSettings->website_name : 'SRI CRACKERS' }}</span>
            </div>
            <p class="text-xs text-amber-100/70 leading-relaxed">
                {{ isset($globalSettings) && $globalSettings->footer_text ? $globalSettings->footer_text : 'Your trusted partner for authentic, safe, and high-quality Sivakasi crackers at wholesale prices.' }}
            </p>
            @if(isset($globalSettings) && ($globalSettings->facebook_url || $globalSettings->twitter_url || $globalSettings->instagram_url))
                <div class="flex gap-3 mt-4">
                    @if($globalSettings->facebook_url)
                        <a href="{{ $globalSettings->facebook_url }}" target="_blank" class="text-amber-100 hover:text-white"><i data-lucide="facebook" class="w-4 h-4"></i></a>
                    @endif
                    @if($globalSettings->twitter_url)
                        <a href="{{ $globalSettings->twitter_url }}" target="_blank" class="text-amber-100 hover:text-white"><i data-lucide="twitter" class="w-4 h-4"></i></a>
                    @endif
                    @if($globalSettings->instagram_url)
                        <a href="{{ $globalSettings->instagram_url }}" target="_blank" class="text-amber-100 hover:text-white"><i data-lucide="instagram" class="w-4 h-4"></i></a>
                    @endif
                </div>
            @endif
        </div>
        <div>
            <h5 class="text-white font-bold text-sm mb-3 uppercase tracking-wider">Quick Links</h5>
            <ul class="space-y-2 text-xs">
                <li><a href="{{ url('/#about') }}" class="text-amber-100/70 hover:text-amber-300 transition">About Us</a></li>
                <li><a href="{{ url('/price-list') }}" class="text-amber-100/70 hover:text-amber-300 transition">Download Price List</a></li>
                <li><a href="{{ url('/combos') }}" class="text-amber-100/70 hover:text-amber-300 transition">Combo Packages</a></li>
                <li><a href="{{ url('/contact') }}" class="text-amber-100/70 hover:text-amber-300 transition">Contact Us</a></li>
            </ul>
        </div>
        <div>
            <h5 class="text-white font-bold text-sm mb-3 uppercase tracking-wider">Contact Info</h5>
            <p class="text-xs text-amber-100/70 leading-relaxed">
                {!! isset($globalSettings) && $globalSettings->address ? nl2br(e($globalSettings->address)) : 'Sivakasi Main Road,<br />Tamil Nadu, India' !!}<br />
                <strong class="text-amber-200 mt-2 block">Phone:</strong> {{ isset($globalSettings) && $globalSettings->phone ? $globalSettings->phone : '+91 98765 43210' }}<br />
                <strong class="text-amber-200">Email:</strong> {{ isset($globalSettings) && $globalSettings->email ? $globalSettings->email : 'info@sricrackers.com' }}
            </p>
            @if(isset($globalSettings) && $globalSettings->gst_number)
                <p class="text-xs text-amber-100/70 mt-2"><strong class="text-amber-200">GST:</strong> {{ $globalSettings->gst_number }}</p>
            @endif
        </div>
        <div>
            <h5 class="text-white font-bold text-sm mb-3">Newsletter</h5>
            <p class="text-xs text-slate-400 leading-relaxed mb-3">
                Subscribe to get special offers and updates!
            </p>
            <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex">
                @csrf
                <input type="email" name="email" placeholder="Your email address" required class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-l-lg focus:outline-none focus:border-red-500 text-sm text-white placeholder-slate-500">
                <button type="submit" class="bg-red-600 hover:bg-red-700 px-3 py-2 rounded-r-lg transition">
                    <i data-lucide="send" class="w-4 h-4 text-white"></i>
                </button>
            </form>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-6 border-t border-slate-800 text-center text-xs text-slate-500 flex flex-col md:flex-row justify-between items-center gap-4">
        <p>© {{ date('Y') }} Sri Crackers. All rights reserved.</p>
        <p>Built with ❤️ by Sri Crackers Team</p>
    </div>
</footer>
