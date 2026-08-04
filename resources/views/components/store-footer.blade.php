<footer class="bg-[#910A67] text-white py-12 border-t border-pink-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
            <div class="flex items-center gap-3 mb-4">
                @if(isset($settings) && isset($settings['logo_url']))
                    <img src="{{ $settings['logo_url'] }}" alt="Logo" class="h-12 bg-white rounded p-1">
                @else
                    <span class="text-2xl font-black uppercase text-[#FFC000]">SRI CRACKERS</span>
                @endif
            </div>
            <p class="text-sm text-pink-100 leading-relaxed font-medium">
                {{ isset($settings) && isset($settings['footer_text']) ? $settings['footer_text'] : 'Your Trusted Destination for Premium Sivakasi Fireworks' }}
            </p>
        </div>
        
        <div>
            <h5 class="text-[#FFC000] font-black text-lg mb-4 uppercase tracking-wider">Quick Links</h5>
            <ul class="space-y-2 text-sm font-bold text-pink-100">
                <li><a href="{{ url('/') }}" class="hover:text-white transition flex items-center gap-2"><i data-lucide="chevron-right" class="w-4 h-4"></i> Home</a></li>
                <li><a href="{{ url('/categories') }}" class="hover:text-white transition flex items-center gap-2"><i data-lucide="chevron-right" class="w-4 h-4"></i> Categories</a></li>
                <li><a href="{{ url('/price-list') }}" class="hover:text-white transition flex items-center gap-2"><i data-lucide="chevron-right" class="w-4 h-4"></i> Price List</a></li>
                <li><a href="{{ url('/contact') }}" class="hover:text-white transition flex items-center gap-2"><i data-lucide="chevron-right" class="w-4 h-4"></i> Contact</a></li>
            </ul>
        </div>
        
        <div>
            <h5 class="text-[#FFC000] font-black text-lg mb-4 uppercase tracking-wider">Contact Info</h5>
            <div class="text-sm text-pink-100 font-medium space-y-3">
                <div class="flex items-start gap-3">
                    <i data-lucide="map-pin" class="w-5 h-5 mt-0.5 text-[#FFC000]"></i>
                    <p>{{ isset($settings) && isset($settings['address']) ? $settings['address'] : '124/B, Sattur Road, Viswanatham, Sivakasi, Tamil Nadu - 626123' }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <i data-lucide="phone" class="w-5 h-5 text-[#FFC000]"></i>
                    <p>{{ isset($settings) && isset($settings['phone']) ? $settings['phone'] : '+91 90950 43444' }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <i data-lucide="mail" class="w-5 h-5 text-[#FFC000]"></i>
                    <p>{{ isset($settings) && isset($settings['email']) ? $settings['email'] : 'support@sricrackers.com' }}</p>
                </div>
            </div>
        </div>

        <div>
            <h5 class="text-[#FFC000] font-black text-lg mb-4 uppercase tracking-wider">Connect With Us</h5>
            <div class="flex gap-4">
                @if(isset($settings) && isset($settings['instagram_url']))
                    <a href="{{ $settings['instagram_url'] }}" target="_blank" class="w-10 h-10 bg-pink-800 rounded-full flex items-center justify-center hover:bg-[#FFC000] hover:text-[#910A67] transition-colors shadow-lg">
                        <i data-lucide="instagram" class="w-5 h-5"></i>
                    </a>
                @endif
                @if(isset($settings) && isset($settings['youtube_url']))
                    <a href="{{ $settings['youtube_url'] }}" target="_blank" class="w-10 h-10 bg-[#FFC000] rounded-full flex items-center justify-center hover:bg-[#FFC000] hover:text-[#910A67] transition-colors shadow-lg">
                        <i data-lucide="youtube" class="w-5 h-5"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-6 border-t border-pink-800/50 text-center text-sm font-medium text-pink-200">
        <p>{{ isset($settings) && isset($settings['footer_copyright']) ? $settings['footer_copyright'] : '© ' . date('Y') . ' SRI CRACKERS. All Rights Reserved.' }}</p>
    </div>
</footer>
