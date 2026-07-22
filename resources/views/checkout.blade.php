@extends('layouts.store')

@section('title', 'Checkout')

@section('content')
<div class="bg-amber-50/50 py-8 border-b border-amber-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-2">Checkout</h1>
        <p class="text-slate-600">Complete your order securely.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="{ isShippingSame: true }">
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-8 rounded-r-xl shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i data-lucide="alert-circle" class="h-5 w-5 text-red-500"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-bold text-red-800">There were some problems with your input.</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
        @csrf
        <input type="hidden" name="cart_data" :value="JSON.stringify(cart)">
        
        <div class="flex flex-col lg:flex-row gap-8">
            
            {!! '<!-- Left Column: Forms -->' !!}
            <div class="w-full lg:w-2/3 space-y-8">
                
                {!! '<!-- Billing Details -->' !!}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8">
                    <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <i data-lucide="user" class="w-5 h-5 text-red-600"></i> Billing Details
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Full Name *</label>
                            <input type="text" name="billing_name" value="{{ old('billing_name') }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Phone Number *</label>
                            <input type="text" name="billing_phone" value="{{ old('billing_phone') }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-1">Email Address</label>
                            <input type="email" name="billing_email" value="{{ old('billing_email') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-1">Full Address *</label>
                            <textarea name="billing_address" required rows="3" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">{{ old('billing_address') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Town / City *</label>
                            <input type="text" name="billing_city" value="{{ old('billing_city') }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">State *</label>
                            <input type="text" name="billing_state" value="{{ old('billing_state') }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">PIN Code *</label>
                            <input type="text" name="billing_pincode" value="{{ old('billing_pincode') }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                        </div>
                    </div>
                </div>

                {!! '<!-- Shipping Toggle -->' !!}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <label class="flex items-center gap-3 cursor-pointer select-none">
                        <input type="checkbox" name="is_shipping_same" value="1" x-model="isShippingSame" class="w-5 h-5 text-red-600 rounded focus:ring-red-500 border-slate-300">
                        <span class="font-bold text-slate-800">Ship to a different address?</span>
                    </label>
                </div>

                {!! '<!-- Shipping Details -->' !!}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8" x-show="!isShippingSame" x-cloak x-transition>
                    <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <i data-lucide="truck" class="w-5 h-5 text-red-600"></i> Shipping Details
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Full Name *</label>
                            <input type="text" name="shipping_name" value="{{ old('shipping_name') }}" :required="!isShippingSame" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Phone Number *</label>
                            <input type="text" name="shipping_phone" value="{{ old('shipping_phone') }}" :required="!isShippingSame" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-1">Full Address *</label>
                            <textarea name="shipping_address" :required="!isShippingSame" rows="3" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">{{ old('shipping_address') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Town / City *</label>
                            <input type="text" name="shipping_city" value="{{ old('shipping_city') }}" :required="!isShippingSame" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">State *</label>
                            <input type="text" name="shipping_state" value="{{ old('shipping_state') }}" :required="!isShippingSame" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">PIN Code *</label>
                            <input type="text" name="shipping_pincode" value="{{ old('shipping_pincode') }}" :required="!isShippingSame" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                        </div>
                    </div>
                </div>

            </div>

            {!! '<!-- Right Column: Order Summary & Payment -->' !!}
            <div class="w-full lg:w-1/3">
                
                {!! '<!-- Payment Method -->' !!}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8 mb-8">
                    <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <i data-lucide="credit-card" class="w-5 h-5 text-red-600"></i> Payment Method
                    </h2>
                    
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition group has-[:checked]:border-red-500 has-[:checked]:bg-red-50/50">
                            <input type="radio" name="payment_method" value="razorpay" checked class="w-4 h-4 text-red-600 focus:ring-red-500 border-slate-300">
                            <div class="flex-1">
                                <span class="font-bold text-slate-800 block">Razorpay</span>
                                <span class="text-xs text-slate-500">Credit/Debit Cards, NetBanking</span>
                            </div>
                            <i data-lucide="shield-check" class="w-5 h-5 text-slate-400 group-has-[:checked]:text-red-600"></i>
                        </label>
                        
                        <label class="flex items-center gap-3 p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition group has-[:checked]:border-red-500 has-[:checked]:bg-red-50/50">
                            <input type="radio" name="payment_method" value="upi" class="w-4 h-4 text-red-600 focus:ring-red-500 border-slate-300">
                            <div class="flex-1">
                                <span class="font-bold text-slate-800 block">UPI</span>
                                <span class="text-xs text-slate-500">Pay via any UPI App</span>
                            </div>
                            <span class="text-xs font-black bg-slate-100 px-2 py-1 rounded text-slate-600 group-has-[:checked]:bg-red-100 group-has-[:checked]:text-red-700">UPI</span>
                        </label>

                        <label class="flex items-center gap-3 p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition group has-[:checked]:border-red-500 has-[:checked]:bg-red-50/50">
                            <input type="radio" name="payment_method" value="gpay" class="w-4 h-4 text-red-600 focus:ring-red-500 border-slate-300">
                            <div class="flex-1">
                                <span class="font-bold text-slate-800 block">Google Pay</span>
                                <span class="text-xs text-slate-500">Direct payment via GPay</span>
                            </div>
                            <span class="text-xl">🇬</span>
                        </label>
                        
                        <label class="flex items-center gap-3 p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition group has-[:checked]:border-red-500 has-[:checked]:bg-red-50/50">
                            <input type="radio" name="payment_method" value="phonepe" class="w-4 h-4 text-red-600 focus:ring-red-500 border-slate-300">
                            <div class="flex-1">
                                <span class="font-bold text-slate-800 block">PhonePe</span>
                                <span class="text-xs text-slate-500">Pay securely via PhonePe</span>
                            </div>
                            <span class="text-xl">🅿️</span>
                        </label>
                    </div>
                </div>

                {!! '<!-- Order Summary -->' !!}
                <div class="bg-slate-50 rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 sticky top-24">
                    <h2 class="text-xl font-bold text-slate-900 mb-6">Your Order</h2>
                    
                    <div x-show="cart.length === 0" class="text-center text-slate-500 py-8">
                        Your cart is empty.
                    </div>

                    <div x-show="cart.length > 0">
                        <ul class="space-y-4 mb-6 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                            <template x-for="item in cart" :key="item.name">
                                <li class="flex justify-between text-sm">
                                    <div class="flex-1">
                                        <span class="font-bold text-slate-800" x-text="item.name"></span>
                                        <span class="text-slate-500"> × <span x-text="item.quantity"></span></span>
                                    </div>
                                    <span class="font-bold text-slate-900" x-text="'₹' + (item.price * item.quantity).toLocaleString('en-IN')"></span>
                                </li>
                            </template>
                        </ul>

                        <div class="border-t border-slate-200 pt-4 space-y-3">
                            <div class="flex justify-between text-sm text-slate-600">
                                <span>Subtotal</span>
                                <span class="font-bold text-slate-900" x-text="'₹' + cartTotal.toLocaleString('en-IN')"></span>
                            </div>
                            <div class="flex justify-between text-sm text-slate-600">
                                <span>Estimated GST (18%)</span>
                                <span class="font-bold text-slate-900" x-text="'₹' + (cartTotal * 0.18).toLocaleString('en-IN')"></span>
                            </div>
                        </div>

                        <div class="border-t border-slate-200 pt-4 mt-4">
                            <div class="flex justify-between items-center mb-6">
                                <span class="text-lg font-bold text-slate-900">Total</span>
                                <span class="text-2xl font-black text-red-600" x-text="'₹' + (cartTotal * 1.18).toLocaleString('en-IN')"></span>
                            </div>

                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-4 rounded-xl shadow-lg transition-transform transform active:scale-95 flex items-center justify-center gap-2 uppercase tracking-wide text-sm">
                                <i data-lucide="check-circle" class="w-5 h-5"></i> Place Order Now
                            </button>
                            <p class="text-center text-xs text-slate-500 mt-4">
                                By placing your order, you agree to our Terms & Conditions.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection
