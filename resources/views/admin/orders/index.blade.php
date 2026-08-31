@extends('admin.layouts.app')

@section('title', 'Manage Orders')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800">Manage Orders</h2>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 shadow-sm py-2 px-3 mb-4">
        <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
    </div>
@endif

<div class="card shadow mb-4 border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Order Number</th>
                        <th>Customer</th>
                        <th>Contact</th>
                        <th>Total</th>
                        <th>Payment Status</th>
                        <th>Order Status</th>
                        <th>Date</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="ps-4">
                            <span class="font-monospace fw-bold">{{ $order->order_number }}</span>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $order->billing_name }}</div>
                            <div class="small text-muted">{{ $order->billing_phone }}</div>
                        </td>
                        <td>
                            <div class="small text-muted">{{ $order->billing_email }}</div>
                        </td>
                        <td>
                            <span class="fw-bold">₹{{ number_format($order->total_amount, 2) }}</span>
                        </td>
                        <td>
                            @php
                                $paymentStatusColors = [
                                    'payment_pending' => 'bg-warning text-dark',
                                    'payment_confirmed' => 'bg-success text-white',
                                ];
                                $paymentBadgeClass = $paymentStatusColors[$order->payment_status] ?? 'bg-secondary text-white';
                            @endphp
                            <span class="badge {{ $paymentBadgeClass }} rounded-pill px-3 py-2 text-uppercase" style="font-size: 0.7rem; tracking: 1px;">
                                {{ ucwords(str_replace('_', ' ', $order->payment_status ?? 'payment_pending')) }}
                            </span>
                        </td>
                        <td>
                            @php
                                $statusColors = [
                                    'pending_confirmation' => 'bg-warning text-dark',
                                    'confirmed' => 'bg-info text-white',
                                    'processing' => 'bg-primary text-white',
                                    'completed' => 'bg-success text-white',
                                    'cancelled' => 'bg-danger text-white',
                                ];
                                $badgeClass = $statusColors[$order->status] ?? 'bg-secondary text-white';
                            @endphp
                            <span class="badge {{ $badgeClass }} rounded-pill px-3 py-2 text-uppercase" style="font-size: 0.7rem; tracking: 1px;">
                                {{ ucwords(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </td>
                        <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                        <td class="text-end pe-4">
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-light border shadow-sm" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-light border shadow-sm" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="{{ route('admin.invoices.show', $order->order_number) }}" class="btn btn-sm btn-light border shadow-sm" title="Invoice">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </a>
                                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this order?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border shadow-sm text-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                            No orders found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($orders->hasPages())
    <div class="card-footer bg-white border-0 py-3">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection
