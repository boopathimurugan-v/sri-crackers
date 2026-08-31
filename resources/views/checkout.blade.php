@extends('layouts.store')

@section('title', 'Checkout')

@section('content')

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

    <div id="checkout-ajax-errors" class="hidden bg-red-50 border-l-4 border-red-500 p-4 mb-8 rounded-r-xl shadow-sm">
        <div class="flex">
            <div class="flex-shrink-0">
                <i data-lucide="alert-circle" class="h-5 w-5 text-red-500"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-bold text-red-800" id="checkout-ajax-error-title">There were some problems with your order.</h3>
                <ul class="mt-2 text-sm text-red-700 list-disc list-inside" id="checkout-ajax-error-list"></ul>
            </div>
        </div>
    </div>

    <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
        @csrf
        <input type="hidden" name="cart_data" :value="JSON.stringify(cart)">

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

            {!! '<!-- Right Column: Order Summary -->' !!}
            <div class="w-full lg:w-5/12 space-y-8">

                {!! '<!-- Order Summary -->' !!}
                <div class="bg-slate-50 rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 sticky top-24">
                    <h2 class="text-xl font-bold text-slate-900 mb-6">Order Summary</h2>

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

                        <div class="border-t border-slate-200 pt-4 space-y-2">
                            <div class="flex justify-between text-sm text-slate-600">
                                <span>Net Amount</span>
                                <span class="font-bold text-slate-900" x-text="'₹' + netAmount.toLocaleString('en-IN')"></span>
                            </div>
                            <div class="flex justify-between text-sm text-green-700">
                                <span>Discount</span>
                                <span class="font-bold" x-text="'-₹' + discountAmount.toLocaleString('en-IN')"></span>
                            </div>
                        </div>

                        <div class="border-t border-slate-200 pt-4 mt-4">
                            <div class="flex justify-between items-center mb-6">
                                <span class="text-lg font-bold text-slate-900">Total Amount</span>
                                <span class="text-2xl font-black text-amber-600" x-text="'₹' + finalPayable.toLocaleString('en-IN')"></span>
                            </div>

                            <!-- LARGE FULL WIDTH PREMIUM GOLD GRADIENT PLACE ORDER BUTTON -->
                            <button type="submit" id="place-order-btn" class="w-full bg-gradient-to-r from-amber-500 via-amber-400 to-yellow-500 hover:from-amber-600 hover:to-yellow-600 text-slate-950 font-black py-4.5 rounded-2xl shadow-lg shadow-amber-500/25 hover:shadow-xl hover:shadow-amber-500/30 transition-all duration-200 transform hover:-translate-y-0.5 active:scale-95 flex items-center justify-center gap-2 uppercase tracking-wide text-base disabled:opacity-60 disabled:cursor-not-allowed disabled:hover:translate-y-0">
                                <span id="place-order-btn-content" class="flex items-center justify-center gap-2">
                                    <i data-lucide="check-circle-2" class="w-6 h-6"></i> Place Order
                                </span>
                            </button>

                            <p class="text-center text-xs text-slate-500 mt-4">
                                No online payment required. Our team will contact you to confirm your order and payment.
                            </p>
                            <p class="text-center text-xs text-slate-500 mt-1">
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
    document.getElementById('checkout-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const form = e.target;
        const btn = document.getElementById('place-order-btn');
        const btnContent = document.getElementById('place-order-btn-content');
        const errorBox = document.getElementById('checkout-ajax-errors');
        const errorTitle = document.getElementById('checkout-ajax-error-title');
        const errorList = document.getElementById('checkout-ajax-error-list');

        if (btn.disabled) {
            // Already submitting — ignore extra clicks instead of firing a second request.
            return;
        }

        const originalContent = btnContent.innerHTML;

        function showErrors(message, errors) {
            errorList.innerHTML = '';

            const messages = [];
            if (errors && typeof errors === 'object') {
                Object.values(errors).forEach(function (value) {
                    if (Array.isArray(value)) {
                        value.forEach(function (v) { messages.push(v); });
                    } else if (value) {
                        messages.push(value);
                    }
                });
            }
            if (messages.length === 0 && message) {
                messages.push(message);
            }

            messages.forEach(function (msg) {
                const li = document.createElement('li');
                li.textContent = msg;
                errorList.appendChild(li);
            });

            errorTitle.textContent = message || 'There were some problems with your order.';
            errorBox.classList.remove('hidden');
            errorBox.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        function setLoading(isLoading) {
            btn.disabled = isLoading;
            if (isLoading) {
                btnContent.innerHTML = '<svg class="animate-spin h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg> Placing Order...';
            } else {
                btnContent.innerHTML = originalContent;
                if (window.lucide) { window.lucide.createIcons(); }
            }
        }

        errorBox.classList.add('hidden');
        setLoading(true);

        const formData = new FormData(form);
        const token = form.querySelector('input[name="_token"]').value;

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
            },
            body: formData,
        })
            .then(function (response) {
                return response.json().then(function (data) {
                    return { status: response.status, ok: response.ok, data: data };
                });
            })
            .then(function (result) {
                if (result.ok && result.data && result.data.success) {
                    window.location.href = result.data.redirect;
                    return; // keep the button disabled/spinning through the redirect
                }

                setLoading(false);
                showErrors(
                    (result.data && result.data.message) || 'Something went wrong. Please try again.',
                    result.data && result.data.errors
                );
            })
            .catch(function () {
                setLoading(false);
                showErrors('Could not reach the server. Please check your connection and try again.', null);
            });
    });
</script>
@endsection
