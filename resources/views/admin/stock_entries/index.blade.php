@extends('admin.layouts.app')

@section('title', 'Stock Entry & Inventory Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0"><i class="bi bi-boxes text-success me-2"></i>Stock Entry Management</h2>
        <p class="text-muted small m-0">Manually update product stock levels and view complete inventory stock history.</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4 mb-4">
    <!-- MANUAL STOCK ENTRY FORM -->
    <div class="col-md-5">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3">
                <h5 class="m-0 fw-bold text-dark"><i class="bi bi-plus-circle me-2 text-success"></i>Update Product Stock</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.stock-entries.store') }}" method="POST" id="stockForm">
                    @csrf

                    <div class="mb-3">
                        <label for="product_id" class="form-label font-weight-bold">Select Product <span class="text-danger">*</span></label>
                        <select class="form-select @error('product_id') is-invalid @enderror" id="product_id" name="product_id" required onchange="updateStockCalculation()">
                            <option value="" data-stock="0">-- Choose Product --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-stock="{{ $product->stock }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} (Code: {{ $product->product_code ?? 'N/A' }}) - Stock: {{ $product->stock }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="current_stock" class="form-label text-muted">Current Stock</label>
                            <input type="number" class="form-control bg-light" id="current_stock" value="0" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="added_quantity" class="form-label">Add Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('added_quantity') is-invalid @enderror" id="added_quantity" name="added_quantity" value="{{ old('added_quantity', 10) }}" required oninput="updateStockCalculation()">
                            @error('added_quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="p-3 bg-success bg-opacity-10 rounded border border-success border-opacity-25 mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-success">Calculated New Stock:</span>
                            <span class="fs-4 fw-extrabold text-success" id="total_stock_preview">0</span>
                        </div>
                        <small class="text-muted d-block mt-1">New Stock = Current Stock + Add Quantity</small>
                    </div>

                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks / Note</label>
                        <input type="text" class="form-control @error('remarks') is-invalid @enderror" id="remarks" name="remarks" value="{{ old('remarks') }}" placeholder="e.g. Received new Sivakasi stock shipment">
                        @error('remarks') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success py-2.5 fw-bold">
                            <i class="bi bi-save me-1"></i> Save Stock Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- CURRENT PRODUCT STOCK LIST TABLE -->
    <div class="col-md-7">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="m-0 fw-bold text-dark"><i class="bi bi-list-check me-2 text-primary"></i>Current Product Stock Overview</h5>
                <span class="badge bg-secondary">{{ count($products) }} Total Products</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 380px; overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>Product Name</th>
                                <th>Code</th>
                                <th class="text-center">Current Stock</th>
                                <th class="text-center">Stock Badge</th>
                                <th>Last Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $prod)
                                <tr>
                                    <td>
                                        <strong class="text-dark">{{ $prod->name }}</strong>
                                    </td>
                                    <td><span class="font-monospace text-muted small">{{ $prod->product_code ?? '-' }}</span></td>
                                    <td class="text-center fw-bold fs-6">{{ $prod->stock }}</td>
                                    <td class="text-center">
                                        @if($prod->stock > 0)
                                            <span class="badge bg-success">In Stock</span>
                                        @else
                                            <span class="badge bg-danger">Out of Stock</span>
                                        @endif
                                    </td>
                                    <td class="small text-muted">{{ $prod->updated_at->format('d M Y, h:i A') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- STOCK HISTORY LOG TABLE -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h5 class="m-0 fw-bold text-dark"><i class="bi bi-clock-history me-2 text-info"></i>Stock Audit History</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Product Name</th>
                        <th class="text-center">Previous Stock</th>
                        <th class="text-center">Added Quantity</th>
                        <th class="text-center">New Stock</th>
                        <th>Remarks</th>
                        <th>Updated By</th>
                        <th class="text-end pe-4">Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stockHistories as $history)
                        <tr>
                            <td class="ps-4">
                                <strong class="text-dark">{{ $history->product->name ?? 'Deleted Product' }}</strong>
                            </td>
                            <td class="text-center text-muted fw-semibold">{{ $history->previous_stock }}</td>
                            <td class="text-center fw-bold text-{{ $history->added_quantity >= 0 ? 'success' : 'danger' }}">
                                {{ $history->added_quantity >= 0 ? '+' . $history->added_quantity : $history->added_quantity }}
                            </td>
                            <td class="text-center fw-bold text-dark fs-6">{{ $history->new_stock }}</td>
                            <td><span class="text-muted small">{{ $history->remarks ?? '-' }}</span></td>
                            <td><span class="badge bg-light text-dark border">{{ $history->updated_by }}</span></td>
                            <td class="text-end pe-4 small text-muted">{{ $history->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No stock update history recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($stockHistories->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $stockHistories->links() }}
        </div>
    @endif
</div>

<script>
    function updateStockCalculation() {
        const select = document.getElementById('product_id');
        const selectedOption = select.options[select.selectedIndex];
        const currentStock = parseInt(selectedOption.getAttribute('data-stock') || '0');
        const addedQty = parseInt(document.getElementById('added_quantity').value || '0');

        document.getElementById('current_stock').value = currentStock;
        const totalStock = Math.max(0, currentStock + addedQty);
        document.getElementById('total_stock_preview').innerText = totalStock;
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateStockCalculation();
    });
</script>
@endsection
