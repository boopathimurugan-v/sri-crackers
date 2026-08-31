@extends('admin.layouts.app')

@section('title', 'Edit Order - ' . $order->order_number)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-1 text-gray-800 font-monospace">Edit {{ $order->order_number }}</h2>
        <p class="text-muted mb-0">Placed on {{ $order->created_at->format('l, F j, Y \a\t h:i A') }}</p>
    </div>
    <div>
        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-light border shadow-sm">
            <i class="bi bi-arrow-left"></i> Back to Order
        </a>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm mb-4">
        <strong>There were problems with your input:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.orders.update', $order) }}" method="POST" id="order-edit-form">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-lg-8">

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="mb-0 fw-bold">Billing Details</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">Customer Name</label>
                            <input type="text" name="billing_name" class="form-control" value="{{ old('billing_name', $order->billing_name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">Phone</label>
                            <input type="text" name="billing_phone" class="form-control" value="{{ old('billing_phone', $order->billing_phone) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">Email</label>
                            <input type="email" name="billing_email" class="form-control" value="{{ old('billing_email', $order->billing_email) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">PIN Code</label>
                            <input type="text" name="billing_pincode" class="form-control" value="{{ old('billing_pincode', $order->billing_pincode) }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-muted text-uppercase">Address</label>
                            <textarea name="billing_address" rows="2" class="form-control" required>{{ old('billing_address', $order->billing_address) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">City</label>
                            <input type="text" name="billing_city" class="form-control" value="{{ old('billing_city', $order->billing_city) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">State</label>
                            <input type="text" name="billing_state" class="form-control" value="{{ old('billing_state', $order->billing_state) }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="mb-0 fw-bold">Order Products</h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="border-bottom">
                                <tr>
                                    <th>Item Name</th>
                                    <th style="width: 140px;">Price (₹)</th>
                                    <th style="width: 110px;">Qty</th>
                                    <th class="text-end" style="width: 140px;">Line Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $index => $item)
                                <tr>
                                    <td>
                                        <span class="fw-bold text-dark">{{ $item->item_name }}</span>
                                        <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" min="0" name="items[{{ $index }}][price]" class="form-control item-price" value="{{ old("items.$index.price", $item->price) }}" required>
                                    </td>
                                    <td>
                                        <input type="number" step="1" min="1" name="items[{{ $index }}][quantity]" class="form-control item-qty" value="{{ old("items.$index.quantity", $item->quantity) }}" required>
                                    </td>
                                    <td class="text-end fw-bold line-total">₹{{ number_format($item->total, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-4">

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="mb-0 fw-bold">Amounts</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Net Amount</span>
                        <span class="fw-bold" id="net-amount-display">₹{{ number_format($order->net_amount ?? $order->subtotal, 2) }}</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Discount Amount (₹)</label>
                        <input type="number" step="0.01" min="0" name="discount_amount" id="discount-amount-input" class="form-control" value="{{ old('discount_amount', $order->discount_amount) }}" required>
                    </div>

                    @if($order->gst_amount > 0)
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">GST (unchanged)</span>
                        <span class="fw-bold">₹{{ number_format($order->gst_amount, 2) }}</span>
                    </div>
                    @endif

                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Total Amount</span>
                        <span class="fw-bold fs-5 text-danger" id="total-amount-display">₹{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                    <div class="form-text">Totals are recalculated automatically on save based on the product prices/quantities and discount above.</div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="mb-0 fw-bold">Status</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small text-uppercase" style="letter-spacing: 1px;">Order Status</label>
                        <select name="status" class="form-select form-select-lg shadow-sm" required>
                            <option value="pending_confirmation" {{ old('status', $order->status) == 'pending_confirmation' ? 'selected' : '' }}>🟡 Pending Confirmation</option>
                            <option value="confirmed" {{ old('status', $order->status) == 'confirmed' ? 'selected' : '' }}>🔵 Confirmed</option>
                            <option value="processing" {{ old('status', $order->status) == 'processing' ? 'selected' : '' }}>🟣 Processing</option>
                            <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>🟢 Completed</option>
                            <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>🔴 Cancelled</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-bold text-muted small text-uppercase" style="letter-spacing: 1px;">Payment Status</label>
                        <select name="payment_status" class="form-select form-select-lg shadow-sm" required>
                            <option value="payment_pending" {{ old('payment_status', $order->payment_status) == 'payment_pending' ? 'selected' : '' }}>🟡 Payment Pending</option>
                            <option value="payment_confirmed" {{ old('payment_status', $order->payment_status) == 'payment_confirmed' ? 'selected' : '' }}>🟢 Payment Confirmed</option>
                        </select>
                        @if($order->payment_status !== 'payment_confirmed')
                            <div class="form-text">Setting this to "Payment Confirmed" will automatically generate and email the final invoice to the customer.</div>
                        @endif
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow-sm">
                <i class="bi bi-save me-1"></i> Save Changes
            </button>
        </div>
    </div>
</form>

<script>
    (function () {
        const form = document.getElementById('order-edit-form');
        const discountInput = document.getElementById('discount-amount-input');
        const netDisplay = document.getElementById('net-amount-display');
        const totalDisplay = document.getElementById('total-amount-display');
        const gstAmount = {{ (float) $order->gst_amount }};

        function formatCurrency(value) {
            return '₹' + value.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        function recalculate() {
            let netAmount = 0;

            form.querySelectorAll('tbody tr').forEach(function (row) {
                const priceInput = row.querySelector('.item-price');
                const qtyInput = row.querySelector('.item-qty');
                const lineTotalCell = row.querySelector('.line-total');

                const price = parseFloat(priceInput.value) || 0;
                const qty = parseInt(qtyInput.value) || 0;
                const lineTotal = price * qty;

                lineTotalCell.textContent = formatCurrency(lineTotal);
                netAmount += lineTotal;
            });

            const discount = parseFloat(discountInput.value) || 0;
            const totalAmount = netAmount - discount + gstAmount;

            netDisplay.textContent = formatCurrency(netAmount);
            totalDisplay.textContent = formatCurrency(totalAmount);
        }

        form.addEventListener('input', function (e) {
            if (e.target.matches('.item-price, .item-qty, #discount-amount-input')) {
                recalculate();
            }
        });

        recalculate();
    })();
</script>
@endsection
