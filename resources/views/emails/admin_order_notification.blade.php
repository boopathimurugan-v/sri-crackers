<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order Received - Sri Crackers</title>
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
            background-color: #0f172a;
            padding: 24px 30px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .header p {
            margin: 6px 0 0 0;
            color: #cbd5e1;
            font-size: 13px;
        }
        .content {
            padding: 30px;
        }
        .alert-banner {
            background-color: #fef3c7;
            border: 1px solid #fbbf24;
            color: #92400e;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 24px;
            text-align: center;
        }
        .section-title {
            font-size: 13px;
            font-weight: 700;
            color: #910A67;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0 0 10px 0;
            border-bottom: 2px solid #910A67;
            padding-bottom: 6px;
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
            vertical-align: top;
        }
        .info-label {
            color: #64748b;
            font-weight: 600;
            width: 35%;
        }
        .info-val {
            color: #0f172a;
            font-weight: 700;
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
        <h1>SRI CRACKERS - Admin Alert</h1>
        <p>A new order has been placed on the website</p>
    </div>

    <!-- CONTENT -->
    <div class="content">
        <div class="alert-banner">
            No online payment was collected. Please contact the customer to confirm the order and explain the payment method.
        </div>

        <div class="section-title">Order Info</div>
        <div class="info-card">
            <table>
                <tr>
                    <td class="info-label">Order Number:</td>
                    <td class="info-val" style="font-family: monospace;">{{ $order->order_number }}</td>
                </tr>
                <tr>
                    <td class="info-label">Order Date &amp; Time:</td>
                    <td class="info-val">{{ $order->created_at->format('d M Y, h:i A') }}</td>
                </tr>
                <tr>
                    <td class="info-label">Order Status:</td>
                    <td class="info-val">{{ ucwords(str_replace('_', ' ', $order->status)) }}</td>
                </tr>
                <tr>
                    <td class="info-label">Payment Status:</td>
                    <td class="info-val">{{ ucwords(str_replace('_', ' ', $order->payment_status)) }}</td>
                </tr>
            </table>
        </div>

        <div class="section-title">Customer Details</div>
        <div class="info-card">
            <table>
                <tr>
                    <td class="info-label">Name:</td>
                    <td class="info-val">{{ $order->billing_name }}</td>
                </tr>
                <tr>
                    <td class="info-label">Phone:</td>
                    <td class="info-val">{{ $order->billing_phone }}</td>
                </tr>
                <tr>
                    <td class="info-label">Email:</td>
                    <td class="info-val">{{ $order->billing_email }}</td>
                </tr>
                <tr>
                    <td class="info-label">Address:</td>
                    <td class="info-val">{{ $order->billing_address }}</td>
                </tr>
                <tr>
                    <td class="info-label">City:</td>
                    <td class="info-val">{{ $order->billing_city }}</td>
                </tr>
                <tr>
                    <td class="info-label">State:</td>
                    <td class="info-val">{{ $order->billing_state }}</td>
                </tr>
                <tr>
                    <td class="info-label">PIN Code:</td>
                    <td class="info-val">{{ $order->billing_pincode }}</td>
                </tr>
                @if(!$order->is_shipping_same)
                <tr>
                    <td class="info-label">Shipping Address:</td>
                    <td class="info-val">{{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_pincode }}</td>
                </tr>
                @endif
            </table>
        </div>

        <div class="section-title">Ordered Products</div>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Item Description</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td><strong>{{ $item->item_name }}</strong></td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">₹{{ number_format($item->price, 2) }}</td>
                        <td class="text-right">₹{{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-right" style="color: #64748b;">Net Amount:</td>
                    <td class="text-right">₹{{ number_format($order->net_amount ?? $order->subtotal, 2) }}</td>
                </tr>
                @if($order->discount_amount > 0)
                    <tr>
                        <td colspan="3" class="text-right" style="color: #64748b;">Discount:</td>
                        <td class="text-right">-₹{{ number_format($order->discount_amount, 2) }}</td>
                    </tr>
                @endif
                @if($order->gst_amount > 0)
                    <tr>
                        <td colspan="3" class="text-right" style="color: #64748b;">GST Amount:</td>
                        <td class="text-right">₹{{ number_format($order->gst_amount, 2) }}</td>
                    </tr>
                @endif
                <tr>
                    <td colspan="3" class="text-right grand-total">Final Total:</td>
                    <td class="text-right grand-total">₹{{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        © {{ date('Y') }} SRI CRACKERS. Internal order notification — not intended for customers.
    </div>

</div>

</body>
</html>
