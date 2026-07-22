@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
            <i class="bi bi-calendar3"></i>
            This week
        </button>
    </div>
</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4 mb-4">
    <div class="col">
        <div class="card bg-primary text-white h-100 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="card-title mb-0">Total Orders</h6>
                    <i class="bi bi-box-seam fs-3 opacity-50"></i>
                </div>
                <h3 class="fw-bold mb-0">150</h3>
            </div>
            <div class="card-footer bg-primary border-0 d-flex justify-content-between text-white-50 small">
                <span>View Details</span>
                <i class="bi bi-arrow-right"></i>
            </div>
        </div>
    </div>
    
    <div class="col">
        <div class="card bg-success text-white h-100 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="card-title mb-0">Total Revenue</h6>
                    <i class="bi bi-currency-rupee fs-3 opacity-50"></i>
                </div>
                <h3 class="fw-bold mb-0">₹45,200</h3>
            </div>
            <div class="card-footer bg-success border-0 d-flex justify-content-between text-white-50 small">
                <span>View Details</span>
                <i class="bi bi-arrow-right"></i>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card bg-warning text-dark h-100 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="card-title mb-0">Products</h6>
                    <i class="bi bi-cart3 fs-3 opacity-50"></i>
                </div>
                <h3 class="fw-bold mb-0">12</h3>
            </div>
            <div class="card-footer bg-warning border-0 d-flex justify-content-between text-dark-50 small" style="--bs-text-opacity: .6;">
                <span>View Details</span>
                <i class="bi bi-arrow-right"></i>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card bg-danger text-white h-100 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="card-title mb-0">Pending Shipments</h6>
                    <i class="bi bi-truck fs-3 opacity-50"></i>
                </div>
                <h3 class="fw-bold mb-0">8</h3>
            </div>
            <div class="card-footer bg-danger border-0 d-flex justify-content-between text-white-50 small">
                <span>View Details</span>
                <i class="bi bi-arrow-right"></i>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-bold">Recent Orders</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Order ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ps-4">#ORD-001</td>
                        <td>John Doe</td>
                        <td>Today, 10:23 AM</td>
                        <td>₹2,450</td>
                        <td><span class="badge bg-warning text-dark">Processing</span></td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td class="ps-4">#ORD-002</td>
                        <td>Jane Smith</td>
                        <td>Yesterday</td>
                        <td>₹4,999</td>
                        <td><span class="badge bg-success">Shipped</span></td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
