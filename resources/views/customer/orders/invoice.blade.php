<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $order->order_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-slate-100 py-10 font-sans text-slate-800">
    
    <div class="max-w-4xl mx-auto bg-white p-12 shadow-sm border border-slate-200">
        
        <div class="flex justify-between items-start mb-12">
            <div>
                <h1 class="text-4xl font-black text-red-600 tracking-tight">Sri Crackers</h1>
                <p class="text-slate-500 text-sm mt-1">Light up your celebrations!</p>
                <div class="mt-4 text-sm text-slate-600">
                    <p>123 Crackers Street,</p>
                    <p>Sivakasi, Tamil Nadu - 626123</p>
                    <p>support@sricrackers.com</p>
                </div>
            </div>
            <div class="text-right">
                <h2 class="text-3xl font-bold text-slate-200 uppercase tracking-widest mb-2">Invoice</h2>
                <p class="font-mono font-bold text-slate-900">{{ $order->order_number }}</p>
                <p class="text-sm text-slate-500">Date: {{ $order->created_at->format('d M Y') }}</p>
                <p class="text-sm text-slate-500 mt-2">Status: <span class="font-bold uppercase text-slate-700">{{ $order->status }}</span></p>
            </div>
        </div>

        <div class="flex justify-between mb-12 bg-slate-50 p-6 rounded-lg border border-slate-100">
            <div class="w-1/2">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Billed To</h3>
                <p class="font-bold text-slate-900">{{ $order->billing_name }}</p>
                <p class="text-sm text-slate-600">{{ $order->billing_phone }}</p>
                <p class="text-sm text-slate-600 mt-1">{{ $order->billing_address }}</p>
                <p class="text-sm text-slate-600">{{ $order->billing_city }}, {{ $order->billing_state }} - {{ $order->billing_pincode }}</p>
            </div>
            <div class="w-1/2 text-right">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Shipped To</h3>
                @if($order->is_shipping_same)
                    <p class="text-sm text-slate-500 italic mt-2">Same as billing address</p>
                @else
                    <p class="font-bold text-slate-900">{{ $order->shipping_name }}</p>
                    <p class="text-sm text-slate-600">{{ $order->shipping_phone }}</p>
                    <p class="text-sm text-slate-600 mt-1">{{ $order->shipping_address }}</p>
                    <p class="text-sm text-slate-600">{{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_pincode }}</p>
                @endif
            </div>
        </div>

        <table class="w-full text-left text-sm mb-12">
            <thead>
                <tr class="border-y-2 border-slate-900">
                    <th class="py-3 font-bold text-slate-900">Item Description</th>
                    <th class="py-3 text-center font-bold text-slate-900">Qty</th>
                    <th class="py-3 text-right font-bold text-slate-900">Price</th>
                    <th class="py-3 text-right font-bold text-slate-900">Amount</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 border-b-2 border-slate-900">
                @foreach($order->items as $item)
                <tr>
                    <td class="py-4 font-bold text-slate-800">{{ $item->item_name }}</td>
                    <td class="py-4 text-center">{{ $item->quantity }}</td>
                    <td class="py-4 text-right">₹{{ number_format($item->price, 2) }}</td>
                    <td class="py-4 text-right font-bold text-slate-900">₹{{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-end">
            <div class="w-64 space-y-3">
                <div class="flex justify-between text-sm text-slate-600">
                    <span>Subtotal</span>
                    <span class="font-bold text-slate-900">₹{{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm text-slate-600">
                    <span>GST (18%)</span>
                    <span class="font-bold text-slate-900">₹{{ number_format($order->gst_amount, 2) }}</span>
                </div>
                <div class="flex justify-between pt-3 border-t-2 border-slate-900">
                    <span class="font-bold text-slate-900">Total</span>
                    <span class="text-xl font-black text-red-600">₹{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>
        
        <div class="mt-16 text-center text-sm text-slate-500 border-t border-slate-200 pt-8">
            <p>Thank you for your business!</p>
            <p class="mt-1">For any queries regarding this invoice, please contact support@sricrackers.com.</p>
        </div>

    </div>

    <div class="text-center mt-8 no-print">
        <button onclick="window.print()" class="bg-slate-900 hover:bg-black text-white font-bold py-3 px-8 rounded-xl shadow-md transition">
            Print Invoice
        </button>
    </div>

</body>
</html>
