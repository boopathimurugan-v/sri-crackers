<div x-show="isCartOpen" class="relative z-50" aria-labelledby="slide-over-title" role="dialog" aria-modal="true" x-cloak>
    {!! '<!-- Background backdrop -->' !!}
    <div x-show="isCartOpen" 
         x-transition:enter="ease-in-out duration-500" 
         x-transition:enter-start="opacity-0" 
         x-transition:enter-end="opacity-100" 
         x-transition:leave="ease-in-out duration-500" 
         x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0" 
         class="fixed inset-0 bg-slate-900/75 backdrop-blur-sm transition-opacity" 
         @click="isCartOpen = false"></div>

    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                {!! '<!-- Slide-over panel -->' !!}
                <div x-show="isCartOpen" 
                     x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700" 
                     x-transition:enter-start="translate-x-full" 
                     x-transition:enter-end="translate-x-0" 
                     x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700" 
                     x-transition:leave-start="translate-x-0" 
                     x-transition:leave-end="translate-x-full" 
                     class="pointer-events-auto w-screen max-w-md">
                    <div class="flex h-full flex-col bg-white shadow-2xl">
                        
                        {!! '<!-- Cart Header -->' !!}
                        <div class="flex items-center justify-between px-4 py-6 sm:px-6 bg-red-600 text-white">
                            <h2 class="text-lg font-bold flex items-center gap-2" id="slide-over-title">
                                <i data-lucide="shopping-cart" class="w-5 h-5"></i> 
                                Shopping Cart (<span x-text="cartCount"></span>)
                            </h2>
                            <div class="ml-3 flex h-7 items-center">
                                <button type="button" @click="isCartOpen = false" class="relative -m-2 p-2 text-red-200 hover:text-white transition">
                                    <span class="absolute -inset-0.5"></span>
                                    <span class="sr-only">Close panel</span>
                                    <i data-lucide="x" class="h-6 w-6"></i>
                                </button>
                            </div>
                        </div>

                        {!! '<!-- Cart Body (Empty state) -->' !!}
                        <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6" x-show="cart.length === 0">
                            <div class="flex flex-col items-center justify-center h-full text-slate-500 space-y-4">
                                <div class="bg-slate-100 p-4 rounded-full">
                                    <i data-lucide="shopping-bag" class="w-12 h-12 text-slate-400"></i>
                                </div>
                                <p class="text-lg font-medium text-slate-900">Your cart is empty</p>
                                <p class="text-sm text-center">Looks like you haven't added any crackers to your cart yet.</p>
                                <button @click="isCartOpen = false" class="mt-4 px-6 py-2 bg-amber-100 text-amber-900 font-bold rounded-xl hover:bg-amber-200 transition">
                                    Start Shopping
                                </button>
                            </div>
                        </div>

                        {!! '<!-- Cart Body (Items) -->' !!}
                        <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6" x-show="cart.length > 0">
                            <ul role="list" class="-my-6 divide-y divide-slate-200">
                                <template x-for="(item, index) in cart" :key="index">
                                    <li class="flex py-6">
                                        <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-slate-200 bg-slate-50 flex items-center justify-center text-3xl">
                                            🎆
                                        </div>

                                        <div class="ml-4 flex flex-1 flex-col">
                                            <div>
                                                <div class="flex justify-between text-base font-bold text-slate-900">
                                                    <h3 x-text="item.name"></h3>
                                                    <p class="ml-4" x-text="'₹' + (item.price * item.quantity).toLocaleString('en-IN')"></p>
                                                </div>
                                                <p class="mt-1 text-xs text-slate-500 uppercase tracking-wider font-semibold" x-text="item.category"></p>
                                            </div>
                                            <div class="flex flex-1 items-end justify-between text-sm">
                                                <div class="flex items-center border border-slate-200 rounded-lg">
                                                    <button @click="updateQuantity(index, -1)" class="px-3 py-1 text-slate-600 hover:bg-slate-100 rounded-l-lg transition">-</button>
                                                    <span class="px-3 py-1 font-medium border-x border-slate-200" x-text="item.quantity"></span>
                                                    <button @click="updateQuantity(index, 1)" class="px-3 py-1 text-slate-600 hover:bg-slate-100 rounded-r-lg transition">+</button>
                                                </div>

                                                <div class="flex">
                                                    <button type="button" @click="removeFromCart(index)" class="font-medium text-red-600 hover:text-red-500 text-sm flex items-center gap-1">
                                                        <i data-lucide="trash-2" class="w-4 h-4"></i> Remove
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </template>
                            </ul>
                        </div>

                        {!! '<!-- Cart Footer -->' !!}
                        <div class="border-t border-slate-200 px-4 py-6 sm:px-6 bg-slate-50" x-show="cart.length > 0">
                            <div class="flex justify-between text-base font-bold text-slate-900 mb-4">
                                <p>Subtotal</p>
                                <p x-text="'₹' + cartTotal.toLocaleString('en-IN')"></p>
                            </div>
                            <p class="mt-0.5 text-xs text-slate-500 mb-6">Shipping and taxes calculated at checkout.</p>
                            <div class="mt-6">
                                <a href="{{ route('checkout') }}" class="flex items-center justify-center rounded-xl border border-transparent bg-red-600 px-6 py-3.5 text-base font-bold text-white shadow-md hover:bg-red-700 transition">
                                    Proceed to Checkout
                                </a>
                            </div>
                            <div class="mt-6 flex justify-center text-center text-sm text-slate-500">
                                <p>
                                    or
                                    <button type="button" class="font-medium text-red-600 hover:text-red-500" @click="isCartOpen = false">
                                        Continue Shopping
                                        <span aria-hidden="true"> &rarr;</span>
                                    </button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
