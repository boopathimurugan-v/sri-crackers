<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Sri Crackers</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 650px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
        }
        .header {
            background-color: #910A67;
            padding: 30px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 26px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .header p {
            margin: 6px 0 0 0;
            color: #fbcfe8;
            font-size: 13px;
        }
        .content {
            padding: 30px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 12px;
        }
        .thank-you {
            font-size: 14px;
            color: #475569;
            line-height: 1.6;
            margin-bottom: 24px;
        }
        .info-card {
            background-color: #f1f5f9;
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 24px;
        }
        .info-card table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-card td {
            padding: 6px 0;
            font-size: 13px;
        }
        .info-label {
            color: #64748b;
            font-weight: 600;
            width: 40%;
        }
        .info-val {
            color: #0f172a;
            font-weight: 700;
            text-align: right;
        }
        .badge-status {
            background-color: #059669;
            color: #ffffff;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            display: inline-block;
            text-transform: uppercase;
        }
        .table-title {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 12px;
            border-bottom: 2px solid #910A67;
            padding-bottom: 6px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        .items-table th {
            background-color: #f8fafc;
            color: #475569;
            font-size: 12px;
            font-weight: 700;
            text-align: left;
            padding: 10px;
            border-bottom: 2px solid #e2e8f0;
            text-transform: uppercase;
        }
        .items-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13px;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .grand-total {
            font-size: 16px;
            font-weight: 800;
            color: #910A67;
        }
        .cta-container {
            text-align: center;
            margin: 30px 0;
        }
        .btn-download {
            background-color: #910A67;
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 28px;
            font-size: 14px;
            font-weight: 700;
            border-radius: 30px;
            display: inline-block;
            box-shadow: 0 4px 12px rgba(145, 10, 103, 0.3);
        }
        .company-contact {
            background-color: #f8fafc;
            border-radius: 12px;
            padding: 18px;
            font-size: 12px;
            color: #64748b;
            line-height: 1.6;
            margin-top: 30px;
            border: 1px solid #e2e8f0;
        }
        .company-contact strong {
            color: #0f172a;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 11px;
            color: #94a3b8;
            background-color: #f1f5f9;
        }
    </style>
</head>
<body>

<div class="container">
    
    <!-- HEADER -->
    <div class="header">
        <h1>SRI CRACKERS</h1>
        <p>Premium Sivakasi Fireworks Since 1985 | Order Confirmation</p>
    </div>

    <!-- CONTENT -->
    <div class="content">
        <div class="greeting">Hello {{ $order->billing_name }},</div>
        <div class="thank-you">
            Thank you for placing your order with <strong>SRI CRACKERS</strong>! We have received your UPI payment details and your order has been marked as <strong>Confirmed</strong>. Your official PDF Tax Invoice is attached to this email.
        </div>

        <!-- ORDER INFO CARD -->
        <div class="info-card">
            <table>
                <tr>
                    <td class="info-label">Order Number:</td>
                    <td class="info-val" style="font-family: monospace;">{{ $order->order_number }}</td>
                </tr>
                <tr>
                    <td class="info-label">Order Date:</td>
                    <td class="info-val">{{ $order->created_at->format('d M Y, h:i A') }}</td>
                </tr>
                <tr>
                    <td class="info-label">Payment Method:</td>
                    <td class="info-val">UPI ({{ $order->selected_upi ?? 'Static QR' }})</td>
                </tr>
                <tr>
                    <td class="info-label">Order Status:</td>
                    <td class="info-val">
                        <span class="badge-status">Confirmed</span>
                    </td>
                </tr>
            </table>
        </div>

        <!-- PRODUCT LIST TABLE -->
        <div class="table-title">Ordered Items</div>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Item Description</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    @php
                        $itemName = $item->item_name;
                        $englishPart = $itemName;
                        $tamilPart = null;
                        if (preg_match('/^(.*?)\s*\((.*?)\)$/u', trim($itemName), $matches)) {
                            $englishPart = trim($matches[1]);
                            $tamilPart = trim($matches[2]);
                        }
                    @endphp
                    <tr>
                        <td><strong>{{ $englishPart }}</strong>@if($tamilPart) <span style="font-size: 11px; color: #64748b; font-weight: normal;">({{ $tamilPart }})</span>@endif</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">₹{{ number_format($item->price, 2) }}</td>
                        <td class="text-right">₹{{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-right" style="color: #64748b; padding: 10px;">Net Amount:</td>
                    <td class="text-right" style="padding: 10px;">₹{{ number_format($order->net_amount ?? $order->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right" style="color: #16a34a; padding: 10px;">Discount:</td>
                    <td class="text-right" style="color: #16a34a; padding: 10px;">-₹{{ number_format($order->discount_amount ?? 0, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right grand-total">Grand Total:</td>
                    <td class="text-right grand-total">₹{{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- CTA BUTTON -->
        <div class="cta-container">
            <a href="{{ route('invoices.public-download', $order->order_number) }}" class="btn-download" target="_blank">
                📥 Download Invoice PDF
            </a>
        </div>

        <!-- COMPANY CONTACT DETAILS -->
        <div class="company-contact">
            <strong>SRI CRACKERS SIVAKASI</strong><br>
            124/B, Sattur Road, Viswanatham, Sivakasi, Tamil Nadu - 626123<br>
            📞 Customer Support: <strong>+91 90950 43444</strong><br>
            ✉️ Email Support: <strong>support@sricrackers.com</strong><br>
            🌐 Website: <strong>www.sricrackers.com</strong>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        © {{ date('Y') }} SRI CRACKERS. All rights reserved. Premium Sivakasi Fireworks Since 1985.
    </div>

</div>

</body>
</html>
