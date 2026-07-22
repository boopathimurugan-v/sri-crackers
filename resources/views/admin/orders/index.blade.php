@extends('admin.layouts.app')

@section('title', 'Manage Orders')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800">Manage Orders</h2>
</div>

<div class="card shadow mb-4 border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Order ID</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
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
                            <span class="fw-bold">₹{{ number_format($order->total_amount, 2) }}</span>
                        </td>
                        <td>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-warning text-dark',
                                    'processing' => 'bg-info text-white',
                                    'shipped' => 'bg-primary text-white',
                                    'delivered' => 'bg-success text-white',
                                    'cancelled' => 'bg-danger text-white',
                                ];
                                $badgeClass = $statusColors[$order->status] ?? 'bg-secondary text-white';
                            @endphp
                            <span class="badge {{ $badgeClass }} rounded-pill px-3 py-2 text-uppercase" style="font-size: 0.7rem; tracking: 1px;">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-light border shadow-sm">
                                <i class="bi bi-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
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
