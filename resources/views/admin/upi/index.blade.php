@extends('admin.layouts.app')

@section('title', 'UPI Payment Management & Smart Rotation')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0"><i class="bi bi-qr-code-scan text-primary me-2"></i>UPI Payment & Smart Rotation Dashboard</h2>
        <p class="text-muted small m-0">Manage multiple UPI accounts, daily limits, and smart auto-switch rotation logic.</p>
    </div>
    <div class="d-flex gap-2">
        <form action="{{ route('admin.upi.reset-all-collections') }}" method="POST" onsubmit="return confirm('Are you sure you want to reset ALL daily collections to ₹0?');">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-arrow-counterclockwise"></i> Reset All Daily Collections
            </button>
        </form>
        <a href="{{ route('admin.upi.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Add New UPI Account
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- PAYMENT DASHBOARD METRIC CARDS -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-primary text-white h-100">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small fw-bold uppercase">Total Today's Collection</div>
                        <div class="fs-3 fw-extrabold mt-1">₹{{ number_format($totalTodayCollection, 2) }}</div>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="bi bi-wallet2 fs-3"></i>
                    </div>
                </div>
                <div class="small mt-2 text-white-50">Combined current collection across active accounts</div>
            </div>
        </div>
    </div>

    @foreach($upiAccounts as $index => $upi)
        @php
            $usagePercent = $upi->usagePercentage();
            $bgColor = $usagePercent >= 90 ? 'bg-danger' : ($usagePercent >= 70 ? 'bg-warning' : 'bg-success');
        @endphp
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-secondary">{{ $upi->name }}</span>
                        <span class="badge {{ $upi->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $upi->is_active ? 'Active' : 'Disabled' }}
                        </span>
                    </div>
                    <div class="text-muted small">Daily Limit: ₹{{ number_format($upi->daily_limit, 2) }}</div>
                    <div class="fs-4 fw-bold text-dark">₹{{ number_format($upi->current_collection, 2) }}</div>
                    
                    <div class="mt-2">
                        <div class="d-flex justify-content-between text-xs text-muted mb-1" style="font-size: 0.75rem;">
                            <span>Usage: {{ $usagePercent }}%</span>
                            <span>Rem: ₹{{ number_format($upi->remainingLimit(), 2) }}</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar {{ $bgColor }}" role="progressbar" style="width: {{ $usagePercent }}%" aria-valuenow="{{ $usagePercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- UPI ACCOUNTS SETTINGS TABLE -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold"><i class="bi bi-[#910A67] bi-sliders me-2"></i>UPI Account Management</h5>
        <span class="text-muted small">Smart Auto-Switch evaluates accounts by priority order</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">Order</th>
                        <th>Account Name</th>
                        <th>UPI Details</th>
                        <th>QR Code</th>
                        <th>Daily Limit</th>
                        <th>Current Collection</th>
                        <th>Usage %</th>
                        <th>Status</th>
                        <th>Total Orders</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($upiAccounts as $upi)
                        @php $usage = $upi->usagePercentage(); @endphp
                        <tr>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $upi->display_order }}</span>
                            </td>
                            <td>
                                <strong class="text-primary">{{ $upi->name }}</strong>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $upi->account_holder_name }}</div>
                                <div class="text-muted small font-monospace"><i class="bi bi-qr-code me-1"></i>{{ $upi->upi_id }}</div>
                            </td>
                            <td>
                                @if($upi->qr_image && file_exists(public_path('storage/' . $upi->qr_image)))
                                    <img src="{{ asset('storage/' . $upi->qr_image) }}" alt="QR" class="img-thumbnail" style="height: 45px; width: 45px; object-fit: contain;">
                                @else
                                    <span class="badge bg-light text-muted border">Auto Generated</span>
                                @endif
                            </td>
                            <td class="fw-bold text-dark">₹{{ number_format($upi->daily_limit, 2) }}</td>
                            <td class="fw-bold text-success">₹{{ number_format($upi->current_collection, 2) }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress flex-grow-1" style="height: 8px; width: 60px;">
                                        <div class="progress-bar {{ $usage >= 90 ? 'bg-danger' : ($usage >= 70 ? 'bg-warning' : 'bg-success') }}" style="width: {{ $usage }}%"></div>
                                    </div>
                                    <span class="small fw-bold">{{ $usage }}%</span>
                                </div>
                            </td>
                            <td>
                                <form action="{{ route('admin.upi.toggle-status', $upi) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $upi->is_active ? 'btn-success' : 'btn-secondary' }}" style="font-size: 0.75rem;">
                                        {{ $upi->is_active ? 'Enabled' : 'Disabled' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <span class="badge bg-info text-dark">{{ $upi->orders_count }} Orders</span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <form action="{{ route('admin.upi.reset-collection', $upi) }}" method="POST" class="d-inline" onsubmit="return confirm('Reset collection for {{ $upi->name }}?');">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-warning" title="Reset Collection">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.upi.edit', $upi) }}" class="btn btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.upi.destroy', $upi) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this UPI Account?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-muted">No UPI Accounts found. Click "Add New UPI Account" to create one.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- TODAY'S ORDERS USING UPI ROTATION -->
<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="m-0 fw-bold"><i class="bi bi-receipt me-2 text-success"></i>Today's Orders Summary</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Order Number</th>
                        <th>Customer Name</th>
                        <th>Assigned UPI Account</th>
                        <th>UPI ID</th>
                        <th>Amount (₹)</th>
                        <th>Payment Status</th>
                        <th>Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($todayOrders as $order)
                        <tr>
                            <td>
                                <strong class="font-monospace text-dark">{{ $order->order_number }}</strong>
                            </td>
                            <td>{{ $order->billing_name }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $order->selected_upi ?? ($order->upiAccount->name ?? 'N/A') }}</span>
                            </td>
                            <td class="font-monospace text-muted small">{{ $order->upi_id ?? ($order->upiAccount->upi_id ?? '-') }}</td>
                            <td class="fw-bold">₹{{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                <span class="badge {{ $order->payment_status === 'success' || $order->status === 'processing' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ ucfirst($order->payment_status ?? $order->status) }}
                                </span>
                            </td>
                            <td class="small text-muted">{{ $order->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No orders placed today yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
