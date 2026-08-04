@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 fw-bold text-dark"><i class="bi bi-speedometer2 text-danger me-2"></i>Admin & Payment Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0 gap-2">
        <a href="{{ route('admin.upi.index') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-qr-code-scan me-1"></i> Manage UPI Accounts
        </a>
    </div>
</div>

<!-- GENERAL METRIC CARDS -->
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4 mb-4">
    <div class="col">
        <div class="card bg-primary text-white h-100 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="card-title mb-0">Total Orders</h6>
                    <i class="bi bi-box-seam fs-3 opacity-50"></i>
                </div>
                <h3 class="fw-bold mb-0">{{ $totalOrders ?? 0 }}</h3>
            </div>
            <a href="{{ Route::has('admin.orders.index') ? route('admin.orders.index') : '#' }}" class="card-footer bg-primary border-0 d-flex justify-content-between text-white-50 small text-decoration-none">
                <span>View All Orders</span>
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col">
        <div class="card bg-success text-white h-100 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="card-title mb-0">Total Today's Collection</h6>
                    <i class="bi bi-wallet2 fs-3 opacity-50"></i>
                </div>
                <h3 class="fw-bold mb-0">₹{{ number_format($totalTodayCollection ?? 0, 2) }}</h3>
            </div>
            <a href="{{ route('admin.upi.index') }}" class="card-footer bg-success border-0 d-flex justify-content-between text-white-50 small text-decoration-none">
                <span>View Payment Dashboard</span>
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="col">
        <div class="card bg-warning text-dark h-100 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="card-title mb-0">Total Products</h6>
                    <i class="bi bi-cart3 fs-3 opacity-50"></i>
                </div>
                <h3 class="fw-bold mb-0">{{ $totalProducts ?? 0 }}</h3>
            </div>
            <a href="{{ route('admin.products.index') }}" class="card-footer bg-warning border-0 d-flex justify-content-between text-dark-50 small text-decoration-none">
                <span>Manage Products</span>
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="col">
        <div class="card bg-danger text-white h-100 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="card-title mb-0">Categories</h6>
                    <i class="bi bi-grid fs-3 opacity-50"></i>
                </div>
                <h3 class="fw-bold mb-0">{{ $totalCategories ?? 0 }}</h3>
            </div>
            <a href="{{ route('admin.categories.index') }}" class="card-footer bg-danger border-0 d-flex justify-content-between text-white-50 small text-decoration-none">
                <span>Manage Categories</span>
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<!-- SMART UPI ROTATION PAYMENT DASHBOARD SECTION -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold text-dark">
            <i class="bi bi-cpu text-primary me-2"></i>Smart UPI Rotation Payment Dashboard
        </h5>
        <span class="badge bg-primary">Auto Switch Enabled</span>
    </div>
    <div class="card-body">
        <div class="row g-3">
            @forelse($upiAccounts ?? [] as $upi)
                @php
                    $usage = $upi->usagePercentage();
                    $color = $usage >= 90 ? 'danger' : ($usage >= 70 ? 'warning' : 'success');
                @endphp
                <div class="col-md-4">
                    <div class="p-3 border rounded-3 bg-light">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold text-dark">{{ $upi->name }}</span>
                            <span class="badge bg-{{ $upi->is_active ? 'success' : 'secondary' }}">
                                {{ $upi->is_active ? 'Active' : 'Disabled' }}
                            </span>
                        </div>
                        <div class="text-muted small mb-1">UPI ID: <code class="text-dark">{{ $upi->upi_id }}</code></div>
                        
                        <div class="d-flex justify-content-between align-items-baseline my-2">
                            <span class="fs-5 fw-extrabold text-{{ $color }}">₹{{ number_format($upi->current_collection, 2) }}</span>
                            <span class="text-muted small">Limit: ₹{{ number_format($upi->daily_limit, 2) }}</span>
                        </div>

                        <div class="mt-2">
                            <div class="d-flex justify-content-between small text-muted mb-1" style="font-size: 0.75rem;">
                                <span>Usage %: <strong>{{ $usage }}%</strong></span>
                                <span>Remaining: <strong>₹{{ number_format($upi->remainingLimit(), 2) }}</strong></span>
                            </div>
                            <div class="progress" style="height: 7px;">
                                <div class="progress-bar bg-{{ $color }}" role="progressbar" style="width: {{ $usage }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-3 text-muted">
                    No active UPI accounts set up yet. <a href="{{ route('admin.upi.create') }}" class="fw-bold">Add UPI Account</a>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- TODAY'S ORDERS TABLE -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2 text-info"></i>Today's Orders</h6>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Order Number</th>
                        <th>Customer Name</th>
                        <th>Assigned UPI</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($todayOrders ?? [] as $order)
                        <tr>
                            <td class="ps-4">
                                <strong class="font-monospace text-dark">{{ $order->order_number }}</strong>
                            </td>
                            <td>{{ $order->billing_name }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $order->selected_upi ?? 'Default' }}</span>
                            </td>
                            <td class="fw-bold text-dark">₹{{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                <span class="badge {{ $order->status === 'processing' || $order->status === 'delivered' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-4 small text-muted">
                                {{ $order->created_at->format('d M Y, h:i A') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No orders placed today.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
