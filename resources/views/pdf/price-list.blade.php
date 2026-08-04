<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SRI CRACKERS - Price List</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
            margin: 0;
            padding: 15px;
        }
        .header {
            width: 100%;
            border-bottom: 3px solid #910A67;
            padding-bottom: 12px;
            margin-bottom: 15px;
        }
        .header table {
            width: 100%;
        }
        .company-name {
            font-size: 22px;
            font-weight: bold;
            color: #910A67;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .company-sub {
            font-size: 10px;
            color: #64748b;
            margin-top: 2px;
        }
        .doc-title {
            text-align: right;
            font-size: 16px;
            font-weight: bold;
            color: #0f172a;
        }
        .doc-date {
            text-align: right;
            font-size: 10px;
            color: #475569;
            margin-top: 4px;
        }
        .category-header {
            background-color: #910A67;
            color: #ffffff;
            font-size: 12px;
            font-weight: bold;
            padding: 6px 10px;
            margin-top: 15px;
            margin-bottom: 8px;
            border-radius: 3px;
            text-transform: uppercase;
        }
        table.products-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        table.products-table th {
            background-color: #f1f5f9;
            color: #334155;
            font-size: 10px;
            font-weight: bold;
            text-align: left;
            padding: 6px 8px;
            border-bottom: 1px solid #cbd5e1;
            text-transform: uppercase;
        }
        table.products-table td {
            padding: 5px 8px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10px;
        }
        table.products-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .badge-code {
            font-family: monospace;
            background-color: #e2e8f0;
            padding: 2px 5px;
            border-radius: 2px;
            font-weight: bold;
            color: #334155;
        }
        .price-mrp {
            text-decoration: line-through;
            color: #94a3b8;
            font-size: 9px;
        }
        .price-offer {
            font-weight: bold;
            color: #047857;
            font-size: 11px;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 9px;
            color: #94a3b8;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            padding-top: 6px;
        }
    </style>
</head>
<body>

    <div class="header">
        <table>
            <tr>
                <td style="width: 60%;">
                    @if(isset($companyLogo) && $companyLogo)
                        <img src="{{ $companyLogo }}" alt="Logo" style="max-height: 45px; margin-bottom: 5px;">
                    @else
                        <div class="company-name">{{ $companyName }}</div>
                    @endif
                    <div class="company-sub">Premium Sivakasi Fireworks Since 1985 | {{ $companyAddress }}</div>
                    <div class="company-sub">Phone: {{ $companyPhone }} | Email: {{ $companyEmail }}</div>
                </td>
                <td style="width: 40%;" class="text-right">
                    <div class="doc-title">OFFICIAL PRICE LIST</div>
                    <div class="doc-date">Generated Date: <strong>{{ $currentDate }}</strong></div>
                </td>
            </tr>
        </table>
    </div>

    @foreach($groupedProducts as $categoryName => $products)
        <div class="category-header">
            📁 {{ $categoryName }} ({{ count($products) }} Products)
        </div>

        <table class="products-table">
            <thead>
                <tr>
                    <th style="width: 12%;">Code</th>
                    <th style="width: 48%;">Product Name</th>
                    <th style="width: 15%;">Unit</th>
                    <th style="width: 12%;" class="text-right">MRP (₹)</th>
                    <th style="width: 13%;" class="text-right">Offer Price (₹)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>
                            <span class="badge-code">{{ $product->product_code ?? $product->sku ?? ('SRI-' . str_pad($product->id, 3, '0', STR_PAD_LEFT)) }}</span>
                        </td>
                        <td>
                            <strong>{{ $product->english_name }}</strong>@if($product->tamil_name) <span style="font-size: 11px; color: #64748b; font-weight: normal;">({{ $product->tamil_name }})</span>@endif
                        </td>
                        <td>{{ $product->unit ?? 'Box' }}</td>
                        <td class="text-right price-mrp">
                            ₹{{ number_format($product->mrp, 2) }}
                        </td>
                        <td class="text-right price-offer">
                            ₹{{ number_format($product->offer_price, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    <div class="footer">
        {{ $companyName }} - Premium Sivakasi Fireworks | Wholesale & Retail Price List | Generated on {{ $currentDate }}
    </div>

</body>
</html>
