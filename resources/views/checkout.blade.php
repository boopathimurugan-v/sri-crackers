@extends('layouts.store')

@section('title', 'Checkout')

@section('content')
@php
    $activeUpi = isset($activeUpi) && $activeUpi ? $activeUpi : \App\Models\UpiAccount::where('is_active', true)->orderBy('display_order', 'asc')->orderBy('id', 'asc')->first();
@endphp

<div class="bg-amber-50/50 py-8 border-b border-amber-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-2">Checkout</h1>
        <p class="text-slate-600">Complete your order securely with Sri Crackers.</p>
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

    <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data" id="checkout-form">
        @csrf
        <input type="hidden" name="cart_data" :value="JSON.stringify(cart)">
        <input type="hidden" name="payment_method" value="upi">
        
        <div class="flex flex-col lg:flex-row gap-8">
            
            {!! '<!-- Left Column: Forms -->' !!}
            <div class="w-full lg:w-7/12 space-y-8">
                
                {!! '<!-- Billing Details -->' !!}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8">
                    <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <i data-lucide="user" class="w-5 h-5 text-red-600"></i> Billing Details
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Full Name *</label>
                            <input type="text" name="billing_name" value="{{ old('billing_name') }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Phone Number *</label>
                            <input type="text" name="billing_phone" value="{{ old('billing_phone') }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-1">Email Address *</label>
                            <input type="email" name="billing_email" value="{{ old('billing_email') }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition" placeholder="Order confirmation & invoice PDF will be sent here">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-1">Full Address *</label>
                            <textarea name="billing_address" required rows="3" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition">{{ old('billing_address') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Town / City *</label>
                            <input type="text" name="billing_city" value="{{ old('billing_city') }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">State *</label>
                            <input type="text" name="billing_state" value="{{ old('billing_state') }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">PIN Code *</label>
                            <input type="text" name="billing_pincode" value="{{ old('billing_pincode') }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition">
                        </div>
                    </div>
                </div>

                {!! '<!-- Shipping Toggle -->' !!}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <label class="flex items-center gap-3 cursor-pointer select-none">
                        <input type="checkbox" name="is_shipping_same" value="1" x-model="isShippingSame" class="w-5 h-5 text-amber-600 rounded focus:ring-amber-500 border-slate-300">
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
                            <input type="text" name="shipping_name" value="{{ old('shipping_name') }}" :required="!isShippingSame" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Phone Number *</label>
                            <input type="text" name="shipping_phone" value="{{ old('shipping_phone') }}" :required="!isShippingSame" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-1">Full Address *</label>
                            <textarea name="shipping_address" :required="!isShippingSame" rows="3" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition">{{ old('shipping_address') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Town / City *</label>
                            <input type="text" name="shipping_city" value="{{ old('shipping_city') }}" :required="!isShippingSame" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">State *</label>
                            <input type="text" name="shipping_state" value="{{ old('shipping_state') }}" :required="!isShippingSame" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">PIN Code *</label>
                            <input type="text" name="shipping_pincode" value="{{ old('shipping_pincode') }}" :required="!isShippingSame" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition">
                        </div>
                    </div>
                </div>

            </div>

            {!! '<!-- Right Column: Order Summary & Premium Single UPI Payment Card -->' !!}
            <div class="w-full lg:w-5/12 space-y-8">
                
                {!! '<!-- PREMIUM SECURE UPI PAYMENT CARD -->' !!}
                <div class="bg-white rounded-3xl border-2 border-amber-400 shadow-xl shadow-amber-100/50 p-6 sm:p-8 relative overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gradient-to-r from-amber-500 to-yellow-500 text-slate-950 font-black text-xs uppercase tracking-wider rounded-full shadow-sm">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5"></i> Secure UPI Payment
                        </span>
                        <span class="text-xs font-bold text-slate-400 uppercase">Smart Allocated</span>
                    </div>

                    <h2 class="text-xl font-extrabold text-slate-900 mb-2">Pay via Dynamic QR Code</h2>
                    <p class="text-xs text-slate-500 mb-6">Scan using Google Pay, PhonePe, Paytm, BHIM or any UPI App</p>
                    
                    @if($activeUpi)
                        <!-- DYNAMIC QR CODE DISPLAY -->
                        <div class="relative w-52 h-52 mx-auto bg-white p-3 border-2 border-dashed border-amber-400 rounded-2xl shadow-inner mb-6 flex items-center justify-center">
                            @if($activeUpi->qr_image && file_exists(public_path('storage/' . $activeUpi->qr_image)))
                                <img src="{{ asset('storage/' . $activeUpi->qr_image) }}" alt="UPI QR Code" class="w-full h-full object-contain rounded-xl">
                            @else
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ urlencode('upi://pay?pa='.$activeUpi->upi_id.'&pn='.$activeUpi->account_holder_name.'&cu=INR') }}" alt="UPI QR Code" class="w-full h-full object-contain rounded-xl">
                            @endif
                        </div>

                        <!-- UPI ACCOUNT DETAILS -->
                        <div class="bg-amber-50/70 border border-amber-200/80 rounded-2xl p-4 mb-6 text-xs space-y-2.5">
                            <div class="flex justify-between items-center pb-2 border-b border-amber-200/60">
                                <span class="text-amber-800 font-bold uppercase">Account Name</span>
                                <span class="font-extrabold text-slate-900">{{ $activeUpi->account_holder_name ?? $activeUpi->name }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-amber-800 font-bold uppercase">UPI ID</span>
                                <div class="flex items-center gap-2">
                                    <span id="checkoutUpiId" class="font-mono font-bold text-amber-700 text-sm">{{ $activeUpi->upi_id }}</span>
                                    <button type="button" onclick="copyCheckoutUpi()" class="bg-amber-200/80 hover:bg-amber-300 text-amber-900 font-bold px-2 py-0.5 rounded text-[10px] transition">
                                        Copy
                                    </button>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl text-xs font-bold mb-6 text-center">
                            Online UPI payment is temporarily unavailable. Please contact customer support.
                        </div>
                    @endif

                    <!-- STEP BY STEP PAYMENT GUIDE -->
                    <div class="mb-6 p-4 bg-slate-50 border border-slate-200/80 rounded-2xl">
                        <div class="text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-3 text-center">Step-by-Step Payment Guide</div>
                        <div class="grid grid-cols-2 gap-2 text-center text-xs">
                            <div class="p-2.5 bg-white rounded-xl border border-slate-200 shadow-2xs">
                                <span class="font-extrabold text-amber-600 block mb-0.5">Step 1</span>
                                <span class="text-slate-800 font-bold text-[11px]">Scan QR Code</span>
                            </div>
                            <div class="p-2.5 bg-white rounded-xl border border-slate-200 shadow-2xs">
                                <span class="font-extrabold text-amber-600 block mb-0.5">Step 2</span>
                                <span class="text-slate-800 font-bold text-[11px]">Complete Payment</span>
                            </div>
                            <div class="p-2.5 bg-white rounded-xl border border-slate-200 shadow-2xs">
                                <span class="font-extrabold text-amber-600 block mb-0.5">Step 3</span>
                                <span class="text-slate-800 font-bold text-[11px]">Upload Screenshot</span>
                            </div>
                            <div class="p-2.5 bg-white rounded-xl border border-slate-200 shadow-2xs">
                                <span class="font-extrabold text-amber-600 block mb-0.5">Step 4</span>
                                <span class="text-slate-800 font-bold text-[11px]">Click Place Order</span>
                            </div>
                        </div>
                    </div>

                    <!-- PAYMENT SCREENSHOT UPLOAD FIELD -->
                    <div class="mb-2">
                        <label for="payment_screenshot" class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider mb-1.5 flex justify-between items-center">
                            <span>Upload Payment Screenshot <span class="text-red-500">*</span></span>
                            <span class="text-[10px] text-amber-700 font-bold bg-amber-100 px-2 py-0.5 rounded">JPG, PNG (Max 5MB)</span>
                        </label>
                        <input type="file" id="payment_screenshot" name="payment_screenshot" accept="image/jpeg,image/png,image/jpg,image/webp" required 
                               class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none text-xs bg-slate-50 focus:bg-white shadow-sm transition">
                        <p class="text-[11px] text-slate-500 mt-1.5">Required. Please attach a clear screenshot image of your completed UPI transaction.</p>
                    </div>

                </div>

                {!! '<!-- Order Summary -->' !!}
                <div class="bg-slate-50 rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 sticky top-24">
                    <h2 class="text-xl font-bold text-slate-900 mb-6">Your Order Summary</h2>
                    
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
                                <span class="font-bold text-slate-900" x-text="'₹' + totalPayable.toLocaleString('en-IN')"></span>
                            </div>
                            <div class="flex justify-between text-sm text-slate-600" x-show="gstEnabled">
                                <span>GST (<span x-text="gstPercentage"></span>%)</span>
                                <span class="font-bold text-slate-900" x-text="'₹' + totalGst.toLocaleString('en-IN')"></span>
                            </div>
                        </div>

                        <div class="border-t border-slate-200 pt-4 mt-4">
                            <div class="flex justify-between items-center mb-6">
                                <span class="text-lg font-bold text-slate-900">Total Payable</span>
                                <span class="text-2xl font-black text-amber-600" x-text="'₹' + finalPayable.toLocaleString('en-IN')"></span>
                            </div>

                            <!-- LARGE FULL WIDTH PREMIUM GOLD GRADIENT PLACE ORDER BUTTON -->
                            <button type="submit" class="w-full bg-gradient-to-r from-amber-500 via-amber-400 to-yellow-500 hover:from-amber-600 hover:to-yellow-600 text-slate-950 font-black py-4.5 rounded-2xl shadow-lg shadow-amber-500/25 hover:shadow-xl hover:shadow-amber-500/30 transition-all duration-200 transform hover:-translate-y-0.5 active:scale-95 flex items-center justify-center gap-2 uppercase tracking-wide text-base">
                                <i data-lucide="check-circle-2" class="w-6 h-6"></i> Place Order Now
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

<script>
    function copyCheckoutUpi() {
        const text = document.getElementById('checkoutUpiId').innerText;
        navigator.clipboard.writeText(text);
        alert('UPI ID copied to clipboard: ' + text);
    }
</script>
@endsection
