@extends('admin.layouts.app')

@section('title', 'Customer Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0"><i class="bi bi-people text-danger me-2"></i>Customer Management</h2>
        <p class="text-muted small m-0">View, search, filter, and manage registered customers and their order history.</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- SEARCH AND FILTERS CARD -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('admin.customers.index') }}" method="GET" class="row g-3 align-items-center">
            
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search by Name, Email, or Mobile..." value="{{ request('search') }}">
                </div>
            </div>

            <div class="col-md-5">
                <div class="btn-group w-100" role="group" aria-label="Filter Options">
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary btn-sm {{ !request('filter') ? 'active' : '' }}">
                        All
                    </a>
                    <a href="{{ route('admin.customers.index', array_merge(request()->query(), ['filter' => 'active'])) }}" class="btn btn-outline-success btn-sm {{ request('filter') == 'active' ? 'active' : '' }}">
                        Active
                    </a>
                    <a href="{{ route('admin.customers.index', array_merge(request()->query(), ['filter' => 'new'])) }}" class="btn btn-outline-info btn-sm {{ request('filter') == 'new' ? 'active' : '' }}">
                        New (30 Days)
                    </a>
                    <a href="{{ route('admin.customers.index', array_merge(request()->query(), ['filter' => 'repeat'])) }}" class="btn btn-outline-primary btn-sm {{ request('filter') == 'repeat' ? 'active' : '' }}">
                        Repeat
                    </a>
                    <a href="{{ route('admin.customers.index', array_merge(request()->query(), ['filter' => 'high_value'])) }}" class="btn btn-outline-warning btn-sm {{ request('filter') == 'high_value' ? 'active' : '' }}">
                        High Value
                    </a>
                </div>
            </div>

            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-filter"></i> Apply Filters</button>
            </div>

        </form>
    </div>
</div>

<!-- CUSTOMERS TABLE CARD -->
<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 90px;">ID</th>
                        <th>Customer Name</th>
                        <th>Email Address</th>
                        <th>Mobile Number</th>
                        <th class="text-center">Total Orders</th>
                        <th>Total Purchase</th>
                        <th>Last Order Date</th>
                        <th>Registration Date</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        @php
                            $lastOrder = $customer->lastOrderDate();
                        @endphp
                        <tr>
                            <td>
                                <span class="badge bg-light text-dark font-monospace border">CUST-{{ str_pad($customer->id, 3, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.customers.show', $customer) }}" class="fw-bold text-dark text-decoration-none hover-primary">
                                    {{ $customer->name }}
                                </a>
                            </td>
                            <td class="text-muted small">{{ $customer->email }}</td>
                            <td class="font-monospace text-dark">{{ $customer->phone ?? 'N/A' }}</td>
                            <td class="text-center">
                                <span class="badge bg-primary rounded-pill px-3">{{ $customer->orders_count }}</span>
                            </td>
                            <td class="fw-bold text-success">
                                ₹{{ number_format($customer->total_spent ?? 0, 2) }}
                            </td>
                            <td class="small text-muted">
                                {{ $lastOrder ? $lastOrder->format('d M Y') : 'No orders' }}
                            </td>
                            <td class="small text-muted">
                                {{ $customer->created_at->format('d M Y') }}
                            </td>
                            <td>
                                <span class="badge {{ $customer->is_blocked ? 'bg-danger' : 'bg-success' }}">
                                    {{ $customer->is_blocked ? 'Blocked' : 'Active' }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-outline-primary" title="View Customer Details & History">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-outline-secondary" title="Edit Customer">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.customers.toggle-block', $customer) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-{{ $customer->is_blocked ? 'success' : 'warning' }}" title="{{ $customer->is_blocked ? 'Unblock Customer' : 'Block Customer' }}">
                                            <i class="bi bi-{{ $customer->is_blocked ? 'unlock' : 'lock' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this customer?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Delete Customer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-muted">No customer accounts found matching your criteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($customers->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $customers->links() }}
        </div>
    @endif
</div>
@endsection
