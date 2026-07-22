@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Products</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add Product
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('admin.products.index') }}" method="GET" class="row g-3 mb-3">
            <div class="col-md-3">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search by name or sku..." name="search" value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </div>
            <div class="col-md-2">
                <select name="category_id" class="form-select" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="filter" class="form-select" onchange="this.form.submit()">
                    <option value="">All Products</option>
                    <option value="available" {{ request('filter') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="unavailable" {{ request('filter') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                    <option value="featured" {{ request('filter') == 'featured' ? 'selected' : '' }}>Featured</option>
                    <option value="trending" {{ request('filter') == 'trending' ? 'selected' : '' }}>Trending</option>
                    <option value="low_stock" {{ request('filter') == 'low_stock' ? 'selected' : '' }}>Low Stock (1-10)</option>
                    <option value="out_of_stock" {{ request('filter') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    <option value="deleted" {{ request('filter') == 'deleted' ? 'selected' : '' }}>Deleted Products</option>
                </select>
            </div>
            <div class="col-md-auto ms-auto">
                <a href="{{ route('admin.products.index') }}" class="btn btn-light">Clear</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="text-decoration-none text-dark">
                                Name
                                @if(request('sort') === 'name')
                                    <i class="bi bi-arrow-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>Category</th>
                        <th>Price (MRP)</th>
                        <th>Stock/Unit</th>
                        <th>Status</th>
                        <th>Availability</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr class="{{ $product->trashed() ? 'table-danger' : '' }}">
                        <td>
                            @if($product->main_image)
                                <img src="{{ Storage::url($product->main_image) }}" alt="{{ $product->name }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded" style="width: 50px; height: 50px;">
                                    <i class="bi bi-box"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold">{{ $product->name }}</div>
                            <small class="text-muted">SKU: {{ $product->sku ?? 'N/A' }}</small>
                            <div class="mt-1">
                                @if($product->featured)<span class="badge bg-primary rounded-pill" style="font-size:0.6rem;">Featured</span>@endif
                                @if($product->trending)<span class="badge bg-danger rounded-pill" style="font-size:0.6rem;">Trending</span>@endif
                            </div>
                        </td>
                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                        <td>
                            <div class="fw-bold text-success">₹{{ $product->offer_price }}</div>
                            @if($product->mrp > $product->offer_price)
                                <small class="text-decoration-line-through text-muted">₹{{ $product->mrp }}</small>
                            @endif
                        </td>
                        <td>
                            @if($product->stock > 10)
                                <span class="badge bg-success">{{ $product->stock }}</span>
                            @elseif($product->stock > 0)
                                <span class="badge bg-warning text-dark">{{ $product->stock }}</span>
                            @else
                                <span class="badge bg-danger">Out of Stock</span>
                            @endif
                            <div class="small text-muted mt-1">{{ $product->unit ?? '-' }}</div>
                        </td>
                        <td>
                            <form action="{{ route('admin.products.toggle-status', $product) }}" method="POST" class="m-0 p-0">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-link p-0 text-decoration-none" {{ $product->trashed() ? 'disabled' : '' }}>
                                    @if($product->status)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('admin.products.toggle-availability', $product) }}" method="POST" class="m-0 p-0">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-link p-0 text-decoration-none" {{ $product->trashed() ? 'disabled' : '' }}>
                                    @if($product->is_available)
                                        <span class="badge bg-primary">Available</span>
                                    @else
                                        <span class="badge bg-secondary">Unavailable</span>
                                    @endif
                                </button>
                            </form>
                        </td>
                        <td>
                            @if($product->trashed())
                                <div class="btn-group btn-group-sm">
                                    <form action="{{ route('admin.products.restore', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success" title="Restore"><i class="bi bi-arrow-counterclockwise"></i></button>
                                    </form>
                                    <form action="{{ route('admin.products.force-delete', $product->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-delete" title="Permanent Delete" data-msg="This will permanently delete the product!"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            @else
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-info text-white" title="View"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-delete" title="Soft Delete" data-msg="You can restore this later."><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">No products found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-end mt-3">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- SweetAlert2 for Delete Confirmation -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                const msg = this.getAttribute('data-msg') || "You won't be able to revert this!";
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: msg,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, proceed!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection
