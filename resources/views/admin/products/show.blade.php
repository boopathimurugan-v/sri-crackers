@extends('admin.layouts.app')

@section('title', 'Product Details - ' . $product->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Product Details</h2>
    <div>
        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary me-2">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Products
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white border-bottom">
                <h5 class="card-title mb-0">Images</h5>
            </div>
            <div class="card-body text-center">
                <h6 class="text-muted text-start mb-3">Main Image</h6>
                @if($product->main_image)
                    <img src="{{ Storage::url($product->main_image) }}" alt="{{ $product->name }}" class="img-fluid rounded border shadow-sm mb-4" style="max-height: 250px;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center rounded border w-100 mb-4" style="min-height: 200px;">
                        <div class="text-muted">
                            <i class="bi bi-image fs-1 d-block mb-2"></i>
                            <span>No Main Image</span>
                        </div>
                    </div>
                @endif

                <h6 class="text-muted text-start mb-3">Gallery Images</h6>
                @if($product->images->count() > 0)
                    <div class="row g-2 justify-content-center">
                        @foreach($product->images as $image)
                            <div class="col-4">
                                <img src="{{ Storage::url($image->image_path) }}" class="img-thumbnail w-100" style="height: 80px; object-fit: cover;" alt="Gallery Image">
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted small text-start">No gallery images uploaded.</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-8 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white border-bottom">
                <h5 class="card-title mb-0">Product Information</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover mb-0">
                    <tbody>
                        <tr>
                            <th style="width: 30%" class="ps-4">ID</th>
                            <td>{{ $product->id }}</td>
                        </tr>
                        <tr>
                            <th class="ps-4">Name</th>
                            <td class="fw-bold">{{ $product->name }}</td>
                        </tr>
                        <tr>
                            <th class="ps-4">Slug</th>
                            <td><code>{{ $product->slug }}</code></td>
                        </tr>
                        <tr>
                            <th class="ps-4">Category</th>
                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="ps-4">Brand</th>
                            <td>{{ $product->brand ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="ps-4">SKU</th>
                            <td>{{ $product->sku ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="ps-4">Short Description</th>
                            <td>{{ $product->short_description ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="ps-4">Long Description</th>
                            <td>{!! nl2br(e($product->long_description)) ?: 'N/A' !!}</td>
                        </tr>
                        <tr>
                            <th class="ps-4">Weight</th>
                            <td>{{ $product->weight ? $product->weight . ' kg' : 'N/A' }}</td>
                        </tr>
                        
                        <!-- Pricing Section -->
                        <tr class="table-light">
                            <td colspan="2" class="fw-bold ps-4">Pricing & Inventory</td>
                        </tr>
                        <tr>
                            <th class="ps-4">MRP</th>
                            <td>₹{{ $product->mrp }}</td>
                        </tr>
                        <tr>
                            <th class="ps-4">Offer Price</th>
                            <td class="text-success fw-bold">₹{{ $product->offer_price }}</td>
                        </tr>
                        <tr>
                            <th class="ps-4">GST</th>
                            <td>{{ $product->gst }}%</td>
                        </tr>
                        <tr>
                            <th class="ps-4">Stock</th>
                            <td>
                                @if($product->stock > 10)
                                    <span class="badge bg-success">{{ $product->stock }} Units</span>
                                @elseif($product->stock > 0)
                                    <span class="badge bg-warning text-dark">{{ $product->stock }} Units (Low Stock)</span>
                                @else
                                    <span class="badge bg-danger">Out of Stock</span>
                                @endif
                            </td>
                        </tr>
                        
                        <!-- Status Section -->
                        <tr class="table-light">
                            <td colspan="2" class="fw-bold ps-4">Settings & Status</td>
                        </tr>
                        <tr>
                            <th class="ps-4">Status</th>
                            <td>
                                @if($product->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="ps-4">Featured</th>
                            <td>
                                @if($product->featured)
                                    <span class="badge bg-primary">Yes</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="ps-4">Trending</th>
                            <td>
                                @if($product->trending)
                                    <span class="badge bg-info text-dark">Yes</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="ps-4">Created At</th>
                            <td>{{ $product->created_at->format('M d, Y h:i A') }}</td>
                        </tr>
                        <tr>
                            <th class="ps-4">Updated At</th>
                            <td>{{ $product->updated_at->format('M d, Y h:i A') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
