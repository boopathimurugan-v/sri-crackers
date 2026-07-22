@extends('admin.layouts.app')

@section('title', 'Order Details - ' . $order->order_number)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-1 text-gray-800 font-monospace">{{ $order->order_number }}</h2>
        <p class="text-muted mb-0">Placed on {{ $order->created_at->format('l, F j, Y \a\t h:i A') }}</p>
    </div>
    <div>
        <a href="{{ route('admin.invoices.download', $order->order_number) }}" class="btn btn-dark shadow-sm me-2">
            <i class="bi bi-file-earmark-pdf"></i> Download Invoice
        </a>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-light border shadow-sm">
            <i class="bi bi-arrow-left"></i> Back to Orders
        </a>
    </div>
</div>

<div class="row">
    {!! '<!-- Main Order Info -->' !!}
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                <h5 class="mb-0 fw-bold">Order Items</h5>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-borderless align-middle">
                        <thead class="border-bottom">
                            <tr>
                                <th>Item Name</th>
                                <th>Price</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td class="fw-bold">{{ $item->item_name }}</td>
                                <td>₹{{ number_format($item->price, 2) }}</td>
                                <td class="text-center">x{{ $item->quantity }}</td>
                                <td class="text-end fw-bold">₹{{ number_format($item->total, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="border-top">
                            <tr>
                                <td colspan="3" class="text-end text-muted pt-3">Subtotal:</td>
                                <td class="text-end fw-bold pt-3">₹{{ number_format($order->subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end text-muted pb-3">GST (18%):</td>
                                <td class="text-end fw-bold pb-3">₹{{ number_format($order->gst_amount, 2) }}</td>
                            </tr>
                            <tr class="bg-light rounded">
                                <td colspan="3" class="text-end fs-5 fw-bold py-3">Total:</td>
                                <td class="text-end fs-5 fw-black text-danger py-3">₹{{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3 text-uppercase text-muted" style="letter-spacing: 1px;">Billing Details</h6>
                        <div class="mb-1 fw-bold text-dark">{{ $order->billing_name }}</div>
                        <div class="mb-1"><i class="bi bi-telephone text-muted me-2"></i> {{ $order->billing_phone }}</div>
                        @if($order->billing_email)<div class="mb-3"><i class="bi bi-envelope text-muted me-2"></i> {{ $order->billing_email }}</div>@endif
                        <hr>
                        <div class="text-muted">
                            {{ $order->billing_address }}<br>
                            {{ $order->billing_city }}, {{ $order->billing_state }} - {{ $order->billing_pincode }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3 text-uppercase text-muted" style="letter-spacing: 1px;">Shipping Details</h6>
                        @if($order->is_shipping_same)
                            <div class="alert alert-light border d-flex align-items-center h-100 m-0">
                                <div>
                                    <i class="bi bi-info-circle text-primary me-2"></i> Shipping address is same as billing address.
                                </div>
                            </div>
                        @else
                            <div class="mb-1 fw-bold text-dark">{{ $order->shipping_name }}</div>
                            <div class="mb-3"><i class="bi bi-telephone text-muted me-2"></i> {{ $order->shipping_phone }}</div>
                            <hr>
                            <div class="text-muted">
                                {{ $order->shipping_address }}<br>
                                {{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_pincode }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! '<!-- Sidebar Info & Status Update -->' !!}
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                <h5 class="mb-0 fw-bold">Update Status</h5>
            </div>
            <div class="card-body p-4">
                
                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm py-2 px-3 mb-4">
                        <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small text-uppercase" style="letter-spacing: 1px;">Current Status</label>
                        <select name="status" class="form-select form-select-lg shadow-sm" required>
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>🟡 Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>🔵 Processing</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>🟣 Shipped</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>🟢 Delivered</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>🔴 Cancelled</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow-sm">
                        <i class="bi bi-save me-1"></i> Save Changes
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
