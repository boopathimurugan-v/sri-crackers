@props(['product'])

<div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col group">
    {!! '<!-- Product Image/Icon area -->' !!}
    <div class="h-44 bg-amber-50/60 flex items-center justify-center text-5xl relative group-hover:bg-amber-100/60 transition overflow-hidden">
        <a href="{{ route('product.show', $product['slug']) }}" class="w-full h-full flex items-center justify-center">
            @if(isset($product['image_path']) && $product['image_path'])
                <img src="{{ Storage::url($product['image_path']) }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover">
            @else
                {{ $product['image_icon'] ?? '🎆' }}
            @endif
        </a>
        
        @if(isset($product['discount']) && $product['discount'])
            <span class="absolute top-3 right-3 bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full z-10">
                {{ $product['discount'] }} OFF
            </span>
        @endif
        
        @if(isset($product['stock']) && $product['stock'] == 0)
            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-[1px] flex items-center justify-center z-10">
                <span class="bg-slate-800 text-white font-bold px-4 py-1.5 rounded-lg text-sm tracking-wide uppercase">Out of Stock</span>
            </div>
        @endif

        {!! '<!-- Quick Actions Overlay -->' !!}
        <div class="absolute inset-x-0 bottom-0 p-3 opacity-0 group-hover:opacity-100 transition-opacity flex justify-center gap-2 z-20">
            <button class="bg-white/90 hover:bg-white text-slate-700 p-2 rounded-full shadow-sm tooltip" title="Quick View">
                <i data-lucide="eye" class="w-4 h-4"></i>
            </button>
            <button class="bg-white/90 hover:bg-white text-slate-700 hover:text-red-600 p-2 rounded-full shadow-sm tooltip" title="Add to Wishlist">
                <i data-lucide="heart" class="w-4 h-4"></i>
            </button>
        </div>
    </div>
    
    {!! '<!-- Product Info -->' !!}
    <div class="p-5 flex-1 flex flex-col justify-between">
        <div>
            <span class="text-[10px] uppercase font-bold tracking-wider text-amber-600 block mb-1">{{ $product['category'] }}</span>
            <h4 class="font-bold text-slate-800 text-base leading-snug line-clamp-2" title="{{ $product['name'] }}">{{ $product['name'] }}</h4>
            <div class="flex items-baseline gap-2 mt-3 mb-4">
                <span class="text-xl font-extrabold text-slate-900">₹{{ number_format($product['price']) }}</span>
                @if(isset($product['original_price']))
                    <span class="text-xs text-slate-400 line-through">₹{{ number_format($product['original_price']) }}</span>
                @endif
            </div>
        </div>
        
        {!! '<!-- Add to Cart Button -->' !!}
        @if(isset($product['stock']) && $product['stock'] > 0)
            <button 
                @click="addToCart({ name: '{{ addslashes($product['name']) }}', category: '{{ addslashes($product['category']) }}', price: {{ $product['price'] }} })" 
                class="w-full bg-amber-50 hover:bg-red-600 hover:text-white text-red-600 font-bold py-2.5 rounded-xl border border-amber-200 hover:border-transparent transition text-sm transform active:scale-95 flex items-center justify-center gap-2">
                <i data-lucide="plus" class="w-4 h-4"></i> Add to Cart
            </button>
        @else
            <button disabled class="w-full bg-slate-100 text-slate-400 font-bold py-2.5 rounded-xl border border-slate-200 cursor-not-allowed text-sm flex items-center justify-center gap-2">
                <i data-lucide="slash" class="w-4 h-4"></i> Unavailable
            </button>
        @endif
    </div>
</div>
