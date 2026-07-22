@extends('layouts.store')

@section('title', 'Processing Payment')

@section('content')
<div class="bg-slate-50 py-16 min-h-[60vh] flex items-center justify-center">
    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden">
            
            <div class="bg-slate-900 py-8 px-8 text-center text-white relative">
                <h1 class="text-2xl font-bold">Secure Payment Gateway</h1>
                <p class="text-slate-400 text-sm mt-1">Order #{{ $order->order_number }}</p>
                <div class="mt-4 inline-block bg-slate-800 text-white font-mono px-4 py-2 rounded-lg text-xl tracking-widest border border-slate-700">
                    ₹{{ number_format($order->total_amount, 2) }}
                </div>
            </div>

            <div class="p-8">
                <div class="text-center mb-8">
                    @php
                        $gateways = [
                            'razorpay' => ['name' => 'Razorpay', 'icon' => 'shield-check', 'color' => 'text-blue-600'],
                            'upi' => ['name' => 'UPI', 'icon' => 'smartphone', 'color' => 'text-orange-600'],
                            'gpay' => ['name' => 'Google Pay', 'icon' => 'smartphone', 'color' => 'text-blue-500'],
                            'phonepe' => ['name' => 'PhonePe', 'icon' => 'smartphone', 'color' => 'text-purple-600'],
                        ];
                        $gateway = $gateways[$transaction->payment_method] ?? ['name' => 'Unknown Gateway', 'icon' => 'credit-card', 'color' => 'text-slate-600'];
                    @endphp
                    
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                        <i data-lucide="{{ $gateway['icon'] }}" class="w-8 h-8 {{ $gateway['color'] }}"></i>
                    </div>
                    <h2 class="text-lg font-bold text-slate-900">Connecting to {{ $gateway['name'] }}</h2>
                    <p class="text-sm text-slate-500 mt-2">Please do not refresh this page or click the back button.</p>
                </div>

                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-8">
                    <div class="flex items-start gap-3 text-amber-800 text-sm">
                        <i data-lucide="info" class="w-5 h-5 shrink-0 mt-0.5"></i>
                        <div>
                            <span class="font-bold block mb-1">Development / Sandbox Mode</span>
                            Since live API keys are not configured, use the buttons below to simulate the gateway callback response.
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center border-t border-slate-100 pt-8">
                    <form action="{{ route('payment.callback', $transaction) }}" method="POST" class="w-full">
                        @csrf
                        <input type="hidden" name="status" value="success">
                        <input type="hidden" name="transaction_ref" value="PAY_{{ strtoupper(Str::random(12)) }}">
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 rounded-xl shadow-md transition flex items-center justify-center gap-2">
                            <i data-lucide="check-circle" class="w-5 h-5"></i> Simulate Success
                        </button>
                    </form>

                    <form action="{{ route('payment.callback', $transaction) }}" method="POST" class="w-full">
                        @csrf
                        <input type="hidden" name="status" value="failed">
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3.5 rounded-xl shadow-md transition flex items-center justify-center gap-2">
                            <i data-lucide="x-circle" class="w-5 h-5"></i> Simulate Failure
                        </button>
                    </form>
                </div>

                {!! '<!-- Gateway Integration Scaffold (Hidden) -->' !!}
                <div class="hidden mt-8 text-xs text-slate-400 border-t border-slate-100 pt-4">
                    <p class="font-mono mb-2">Integration Snippet Ready:</p>
                    <code class="block bg-slate-900 text-green-400 p-4 rounded-lg overflow-x-auto">
                        // Razorpay Example<br>
                        var options = {<br>
                            &nbsp;&nbsp;"key": "YOUR_KEY_ID",<br>
                            &nbsp;&nbsp;"amount": "{{ $order->total_amount * 100 }}", // in paise<br>
                            &nbsp;&nbsp;"currency": "INR",<br>
                            &nbsp;&nbsp;"name": "Sri Crackers",<br>
                            &nbsp;&nbsp;"order_id": "gateway_order_id",<br>
                            &nbsp;&nbsp;"handler": function (response){<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;// Post back to {{ route('payment.callback', $transaction) }}<br>
                            &nbsp;&nbsp;}<br>
                        };<br>
                        // var rzp1 = new Razorpay(options);<br>
                        // rzp1.open();
                    </code>
                </div>

            </div>
            
        </div>

    </div>
</div>

<script>
    // In a real environment, you would dynamically load the gateway script here based on $transaction->payment_method
    // e.g. https://checkout.razorpay.com/v1/checkout.js
</script>
@endsection
