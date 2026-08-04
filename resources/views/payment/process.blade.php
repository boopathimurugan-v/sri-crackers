@extends('layouts.store')

@section('title', 'Complete UPI Payment')

@section('content')
<div class="bg-slate-50 py-12 min-h-[75vh] flex items-center justify-center">
    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
            
            <!-- Top Header -->
            <div class="bg-[#910A67] py-6 px-8 text-center text-white relative">
                <span class="inline-block bg-amber-400 text-slate-900 font-extrabold text-xs px-3 py-1 rounded-full uppercase tracking-wider mb-2">
                    Static UPI Payment System
                </span>
                <h1 class="text-2xl font-bold">SRI CRACKERS Payment</h1>
                <p class="text-pink-100 text-xs mt-1">Order #{{ $order->order_number }} • {{ $order->created_at->format('d M Y, h:i A') }}</p>
                
                <div class="mt-4 inline-block bg-white text-[#910A67] font-black px-6 py-2.5 rounded-2xl text-2xl shadow-inner border border-pink-100">
                    ₹{{ number_format($order->total_amount, 2) }}
                </div>
            </div>

            <div class="p-6 md:p-8">
                
                @if(isset($upiUnavailable) && $upiUnavailable)
                    <!-- ALL UPI ACCOUNTS EXCEEDED LIMIT NOTICE -->
                    <div class="bg-red-50 border-2 border-red-200 rounded-2xl p-6 text-center">
                        <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="alert-triangle" class="w-8 h-8"></i>
                        </div>
                        <h2 class="text-lg font-bold text-red-900 mb-2">Payment Unavailable</h2>
                        <p class="text-sm font-semibold text-red-700 leading-relaxed mb-6">
                            Online UPI payment is temporarily unavailable. Please contact customer support.
                        </p>
                        
                        <div class="bg-white p-4 rounded-xl border border-red-100 text-left text-xs text-slate-600 space-y-2 mb-6">
                            <div class="flex justify-between">
                                <span class="font-bold text-slate-800">Order Number:</span>
                                <span class="font-mono font-bold">{{ $order->order_number }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-bold text-slate-800">Customer Name:</span>
                                <span>{{ $order->billing_name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-bold text-slate-800">Order Amount:</span>
                                <span class="font-bold text-red-600">₹{{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-bold px-6 py-3 rounded-xl text-sm transition">
                            <i data-lucide="phone-call" class="w-4 h-4"></i> Contact Customer Support
                        </a>
                    </div>
                @else
                    <!-- UPI ACCOUNT DETAILED QR PAYMENT -->
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-amber-50 text-amber-800 border border-amber-200 rounded-lg text-xs font-bold mb-3">
                            <i data-lucide="zap" class="w-3.5 h-3.5 text-amber-600"></i> Smart Allocated Account: {{ $order->selected_upi ?? $upiAccount->name }}
                        </div>
                        
                        <!-- QR Image Container -->
                        <div class="relative w-56 h-56 mx-auto bg-white p-3 border-2 border-dashed border-[#910A67] rounded-2xl shadow-md mb-4 flex items-center justify-center">
                            @if($upiAccount->qr_image && file_exists(public_path('storage/' . $upiAccount->qr_image)))
                                <img src="{{ asset('storage/' . $upiAccount->qr_image) }}" alt="UPI QR Code" class="w-full h-full object-contain rounded-xl">
                            @else
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ urlencode('upi://pay?pa='.$upiAccount->upi_id.'&pn='.$upiAccount->account_holder_name.'&am='.$order->total_amount.'&cu=INR') }}" alt="UPI QR Code" class="w-full h-full object-contain rounded-xl">
                            @endif
                        </div>
                        
                        <p class="text-xs text-slate-500 font-medium">Scan QR using GPay, PhonePe, Paytm, or any UPI App</p>
                    </div>

                    <!-- UPI Details Table -->
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 mb-6 text-sm space-y-3">
                        <div class="flex justify-between items-center pb-2 border-b border-slate-200">
                            <span class="text-slate-500 text-xs font-bold uppercase">Account Holder</span>
                            <span class="font-bold text-slate-900">{{ $upiAccount->account_holder_name }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center pb-2 border-b border-slate-200">
                            <span class="text-slate-500 text-xs font-bold uppercase">UPI ID</span>
                            <div class="flex items-center gap-2">
                                <span id="upiIdText" class="font-mono font-bold text-[#910A67] text-base">{{ $upiAccount->upi_id }}</span>
                                <button onclick="copyUpiId()" type="button" class="text-xs bg-pink-100 hover:bg-pink-200 text-[#910A67] font-bold px-2 py-1 rounded transition">
                                    Copy
                                </button>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 text-xs font-bold uppercase">Customer Name</span>
                            <span class="font-semibold text-slate-800">{{ $order->billing_name }}</span>
                        </div>
                    </div>

                    <!-- Complete Payment Form -->
                    <form action="{{ route('payment.callback', $transaction) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <input type="hidden" name="status" value="success">
                        
                        <div>
                            <label for="transaction_ref" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                                Enter UTR / Transaction Reference No. <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="transaction_ref" name="transaction_ref" required placeholder="e.g. 421987654321" 
                                   class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-[#910A67] focus:ring-2 focus:ring-pink-200 outline-none font-mono text-sm shadow-sm">
                            <p class="text-[11px] text-slate-400 mt-1">12-digit UTR/Reference number shown in your UPI app after payment.</p>
                        </div>

                        <div>
                            <label for="payment_screenshot" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                                Upload Payment Screenshot <span class="text-red-500">*</span>
                            </label>
                            <input type="file" id="payment_screenshot" name="payment_screenshot" accept="image/*" required 
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#910A67] focus:ring-2 focus:ring-pink-200 outline-none text-sm bg-white shadow-sm">
                            <p class="text-[11px] text-slate-400 mt-1">Upload a clear screenshot image of your completed UPI transaction.</p>
                        </div>

                        <button type="submit" class="w-full bg-[#910A67] hover:bg-[#7a0856] text-white font-bold py-3.5 rounded-xl shadow-lg shadow-pink-900/20 transition flex items-center justify-center gap-2 text-base">
                            <i data-lucide="check-circle" class="w-5 h-5"></i> Confirm Payment & Place Order
                        </button>
                    </form>
                @endif

            </div>
            
        </div>

    </div>
</div>

<script>
    function copyUpiId() {
        const text = document.getElementById('upiIdText').innerText;
        navigator.clipboard.writeText(text);
        alert('UPI ID copied to clipboard: ' + text);
    }
</script>
@endsection
