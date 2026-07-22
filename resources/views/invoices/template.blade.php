<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $order->invoice_number ?? $order->order_number }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; margin: 0; padding: 20px; font-size: 13px; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); }
        .header { width: 100%; margin-bottom: 30px; }
        .header table { width: 100%; }
        .title { color: #dc2626; font-size: 32px; font-weight: bold; margin: 0; }
        .company-info { text-align: left; }
        .invoice-details { text-align: right; }
        
        .addresses { width: 100%; margin-bottom: 30px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px; }
        .addresses table { width: 100%; }
        .addresses td { width: 50%; vertical-align: top; }
        .addresses h3 { font-size: 12px; color: #64748b; text-transform: uppercase; margin-bottom: 10px; margin-top: 0; }
        
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .items-table th { background: #f8fafc; border-bottom: 2px solid #333; padding: 10px; text-align: left; }
        .items-table td { border-bottom: 1px solid #eee; padding: 10px; }
        .items-table th.right, .items-table td.right { text-align: right; }
        .items-table th.center, .items-table td.center { text-align: center; }
        
        .totals-table { width: 40%; float: right; border-collapse: collapse; }
        .totals-table td { padding: 5px 10px; }
        .totals-table td.right { text-align: right; }
        .totals-table tr.total-row td { border-top: 2px solid #333; font-weight: bold; font-size: 16px; padding-top: 10px; color: #dc2626; }
        
        .footer { clear: both; padding-top: 50px; text-align: center; color: #64748b; font-size: 12px; border-top: 1px solid #eee; margin-top: 50px; }
        
        @media print {
            body { padding: 0; }
            .invoice-box { border: none; box-shadow: none; padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    
    <div class="invoice-box">
        
        <!-- Action Buttons (Hidden when printed or in PDF) -->
        <div class="no-print" style="margin-bottom: 20px; text-align: right;">
            <a href="{{ request()->routeIs('admin.*') ? route('admin.orders.index') : route('customer.orders.show', $order->order_number) }}" style="padding: 10px 15px; background: #64748b; color: white; text-decoration: none; border-radius: 5px; margin-right: 10px;">Back</a>
            <button onclick="window.print()" style="padding: 10px 15px; background: #dc2626; color: white; border: none; border-radius: 5px; cursor: pointer; margin-right: 10px;">Print Invoice</button>
            <a href="{{ request()->routeIs('admin.*') ? route('admin.invoices.download', $order->order_number) : route('customer.invoices.download', $order->order_number) }}" style="padding: 10px 15px; background: #0f172a; color: white; text-decoration: none; border-radius: 5px;">Download PDF</a>
        </div>

        <div class="header">
            <table>
                <tr>
                    <td class="company-info">
                        <h1 class="title">Sri Crackers</h1>
                        <p style="margin: 5px 0 0 0; color: #64748b;">Light up your celebrations!</p>
                        <div style="margin-top: 15px; font-size: 12px; color: #333;">
                            <strong>GSTIN:</strong> 33ABCDE1234F1Z5<br>
                            123 Crackers Street, Sivakasi<br>
                            Tamil Nadu - 626123<br>
                            support@sricrackers.com<br>
                            +91 98765 43210
                        </div>
                    </td>
                    <td class="invoice-details">
                        <h2 style="font-size: 28px; color: #cbd5e1; text-transform: uppercase; letter-spacing: 2px; margin: 0 0 10px 0;">Tax Invoice</h2>
                        <table style="width: auto; float: right; font-size: 12px;">
                            <tr>
                                <td style="text-align: right; padding-right: 15px; color: #64748b;">Invoice No:</td>
                                <td><strong>{{ $order->invoice_number ?? $order->order_number }}</strong></td>
                            </tr>
                            <tr>
                                <td style="text-align: right; padding-right: 15px; color: #64748b;">Order Ref:</td>
                                <td>{{ $order->order_number }}</td>
                            </tr>
                            <tr>
                                <td style="text-align: right; padding-right: 15px; color: #64748b;">Date:</td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <td style="text-align: right; padding-right: 15px; color: #64748b;">Status:</td>
                                <td><strong style="text-transform: uppercase;">{{ $order->status }}</strong></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <div class="addresses">
            <table>
                <tr>
                    <td>
                        <h3>Billed To</h3>
                        <strong>{{ $order->billing_name }}</strong><br>
                        {{ $order->billing_address }}<br>
                        {{ $order->billing_city }}, {{ $order->billing_state }} - {{ $order->billing_pincode }}<br>
                        Phone: {{ $order->billing_phone }}<br>
                        Email: {{ $order->billing_email ?? 'N/A' }}
                    </td>
                    <td>
                        <h3>Shipped To</h3>
                        @if($order->is_shipping_same)
                            <em>Same as billing address</em>
                        @else
                            <strong>{{ $order->shipping_name }}</strong><br>
                            {{ $order->shipping_address }}<br>
                            {{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_pincode }}<br>
                            Phone: {{ $order->shipping_phone }}
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Item Description</th>
                    <th class="center">HSN/SAC</th>
                    <th class="center">Qty</th>
                    <th class="right">Unit Price</th>
                    <th class="right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $item->item_name }}</strong></td>
                    <td class="center">3604</td> <!-- Dummy HSN for firecrackers -->
                    <td class="center">{{ $item->quantity }}</td>
                    <td class="right">₹{{ number_format($item->price, 2) }}</td>
                    <td class="right"><strong>₹{{ number_format($item->total, 2) }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @php
            $cgst = $order->gst_amount / 2;
            $sgst = $order->gst_amount / 2;
        @endphp

        <table class="totals-table">
            <tr>
                <td style="color: #64748b;">Taxable Value</td>
                <td class="right">₹{{ number_format($order->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td style="color: #64748b;">CGST (9%)</td>
                <td class="right">₹{{ number_format($cgst, 2) }}</td>
            </tr>
            <tr>
                <td style="color: #64748b;">SGST (9%)</td>
                <td class="right">₹{{ number_format($sgst, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td>Grand Total</td>
                <td class="right">₹{{ number_format($order->total_amount, 2) }}</td>
            </tr>
        </table>
        
        <div style="clear: both; margin-top: 50px;">
            <p style="font-size: 11px; color: #64748b; font-style: italic;">
                Amount in words: <br>
                <strong style="color: #333;">Indian Rupees {{ \NumberFormatter::create('en_IN', \NumberFormatter::SPELLOUT)->format($order->total_amount) }} only</strong>
            </p>
        </div>

        <div class="footer">
            <p style="margin: 0;">This is a computer generated invoice and does not require a signature.</p>
            <p style="margin: 5px 0 0 0;">Thank you for shopping with Sri Crackers!</p>
        </div>

    </div>

</body>
</html>
