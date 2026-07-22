@props(['combo'])

<div class="bg-white rounded border border-gray-200 shadow-sm overflow-hidden flex flex-col hover:shadow-md transition">
    <div class="aspect-square bg-gray-100 relative overflow-hidden group">
        @if(isset($combo['featured']) && $combo['featured'])
            <span class="absolute top-2 left-2 bg-[#990000] text-white text-[10px] font-bold px-2 py-1 rounded-sm z-10 uppercase tracking-wider">Best Value</span>
        @endif
        
        @if(isset($combo['image_path']) && $combo['image_path'])
            <img src="{{ Storage::url($combo['image_path']) }}" alt="{{ $combo['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
        @else
            <div class="w-full h-full flex items-center justify-center text-6xl group-hover:scale-105 transition duration-500">
                {{ $combo['image_icon'] ?? '📦' }}
            </div>
        @endif
        
        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-2">
            @if(isset($combo['stock']) && $combo['stock'] > 0)
                <button @click.prevent="addToCart({ id: {{ $combo['id'] ?? time() }}, name: '{{ addslashes($combo['name']) }}', price: {{ $combo['price'] }}, image: '' })" class="w-10 h-10 bg-[#990000] text-white rounded-full flex items-center justify-center hover:bg-red-800 transition transform translate-y-4 group-hover:translate-y-0" title="Add to Cart">
                    <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                </button>
            @endif
        </div>
    </div>
    
    <div class="p-4 flex flex-col flex-grow text-center">
        <h3 class="text-sm font-bold text-gray-900 mb-2 uppercase tracking-wide truncate">{{ $combo['name'] }}</h3>
        
        <div class="mt-auto mb-4">
            <div class="flex items-center justify-center gap-2">
                @if(isset($combo['original_price']) && $combo['original_price'] > $combo['price'])
                    <span class="text-xs text-gray-500 line-through">₹{{ number_format($combo['original_price']) }}</span>
                    <span class="text-lg font-black text-[#990000]">₹{{ number_format($combo['price']) }}</span>
                @else
                    <span class="text-lg font-black text-[#990000]">₹{{ number_format($combo['price']) }}</span>
                @endif
            </div>
        </div>
        
        @if(isset($combo['stock']) && $combo['stock'] > 0)
            <button @click.prevent="addToCart({ id: {{ $combo['id'] ?? time() }}, name: '{{ addslashes($combo['name']) }}', price: {{ $combo['price'] }}, image: '' })" class="w-full bg-[#cc0000] hover:bg-[#990000] text-white text-xs font-bold py-2.5 rounded transition flex items-center justify-center gap-2 uppercase tracking-wider">
                <i data-lucide="shopping-cart" class="w-4 h-4"></i> Order Combo Now
            </button>
        @else
            <button disabled class="w-full bg-slate-200 text-slate-500 text-xs font-bold py-2.5 rounded transition flex items-center justify-center gap-2 uppercase tracking-wider cursor-not-allowed">
                Out of Stock
            </button>
        @endif
    </div>
</div>
