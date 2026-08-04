@extends('admin.layouts.app')

@section('title', 'Customer Profile - ' . $customer->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0"><i class="bi bi-person-badge text-primary me-2"></i>Customer Profile</h2>
        <p class="text-muted small m-0">Customer ID: <code class="fw-bold">CUST-{{ str_pad($customer->id, 3, '0', STR_PAD_LEFT) }}</code></p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back to Customers
        </a>
        <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-pencil"></i> Edit Details
        </a>
        <form action="{{ route('admin.customers.toggle-block', $customer) }}" method="POST" class="d-inline">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-{{ $customer->is_blocked ? 'success' : 'warning' }} btn-sm">
                <i class="bi bi-{{ $customer->is_blocked ? 'unlock' : 'lock' }}"></i> {{ $customer->is_blocked ? 'Unblock Customer' : 'Block Customer' }}
            </button>
        </form>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- PERSONAL INFORMATION -->
    <div class="col-md-4">
        <div class="card shadow-sm h-100 border-0">
            <div class="card-header bg-white py-3">
                <h5 class="m-0 fw-bold text-dark"><i class="bi bi-person me-2 text-danger"></i>Personal Information</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4 pb-3 border-bottom">
                    <div class="w-20 h-20 bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 70px; height: 70px;">
                        <i class="bi bi-person-fill fs-1"></i>
                    </div>
                    <h5 class="fw-bold mb-1">{{ $customer->name }}</h5>
                    <span class="badge {{ $customer->is_blocked ? 'bg-danger' : 'bg-success' }}">
                        {{ $customer->is_blocked ? 'Account Blocked' : 'Active Customer' }}
                    </span>
                </div>

                <div class="space-y-3 text-sm">
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted"><i class="bi bi-envelope me-2"></i>Email</span>
                        <strong class="text-dark">{{ $customer->email }}</strong>
                    </div>

                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted"><i class="bi bi-telephone me-2"></i>Mobile</span>
                        <strong class="text-dark">{{ $customer->phone ?? 'Not Provided' }}</strong>
                    </div>

                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted"><i class="bi bi-calendar-check me-2"></i>Registered On</span>
                        <strong class="text-dark">{{ $customer->created_at->format('d M Y, h:i A') }}</strong>
                    </div>

                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted"><i class="bi bi-bag-check me-2"></i>Total Orders</span>
                        <strong class="text-primary">{{ $ordersCount }} Orders</strong>
                    </div>

                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted"><i class="bi bi-currency-rupee me-2"></i>Total Spent</span>
                        <strong class="text-success fs-5">₹{{ number_format($totalSpent, 2) }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SAVED ADDRESSES & DETAILS -->
    <div class="col-md-8">
        <div class="card shadow-sm h-100 border-0">
            <div class="card-header bg-white py-3">
                <h5 class="m-0 fw-bold text-dark"><i class="bi bi-geo-alt me-2 text-primary"></i>Saved Addresses</h5>
            </div>
            <div class="card-body">
                @if($customer->addresses->count() > 0)
                    <div class="row g-3">
                        @foreach($customer->addresses as $address)
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light">
                                    <div class="fw-bold mb-1">{{ $address->name ?? $customer->name }}</div>
                                    <div class="small text-muted mb-2"><i class="bi bi-telephone me-1"></i>{{ $address->phone ?? $customer->phone }}</div>
                                    <p class="small mb-0 text-secondary">
                                        {{ $address->address_line_1 }}@if($address->address_line_2), {{ $address->address_line_2 }}@endif,<br>
                                        {{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted m-0 italic">No saved addresses on file.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- ALL ORDERS HISTORY TABLE -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold text-dark"><i class="bi bi-clock-history me-2 text-success"></i>Order History ({{ $ordersCount }})</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Order Number</th>
                        <th>Date & Time</th>
                        <th>Payment Method</th>
                        <th>Order Status</th>
                        <th class="text-end">Amount (₹)</th>
                        <th class="text-end pe-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customer->orders as $order)
                        <tr>
                            <td class="ps-4">
                                <strong class="font-monospace text-dark">{{ $order->order_number }}</strong>
                            </td>
                            <td class="small text-muted">{{ $order->created_at->format('d M Y, h:i A') }}</td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ strtoupper($order->selected_upi ?? 'UPI') }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $order->status === 'delivered' || $order->status === 'processing' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="text-end fw-bold text-success">
                                ₹{{ number_format($order->total_amount, 2) }}
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary" title="View Order Details">
                                    <i class="bi bi-eye"></i> View Order
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">This customer has not placed any orders yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
