@extends('admin.layouts.app')

@section('title', 'Create Product')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0"><i class="bi bi-box-seam text-danger me-2"></i>Create Product</h2>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Back to Products
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-4 sm:p-5">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row g-4">
                <!-- Left Column -->
                <div class="col-md-6">
                    <h5 class="fw-bold mb-3 pb-2 border-bottom text-dark">
                        <i class="bi bi-info-circle text-primary me-2"></i>Product Identification
                    </h5>

                    <!-- Field 1: Product Name (English) -->
                    <div class="mb-3">
                        <label for="product_name_en" class="form-label fw-bold">Product Name (English) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg @error('product_name_en') is-invalid @enderror" id="product_name_en" name="product_name_en" value="{{ old('product_name_en') }}" placeholder="Example: Flower Pots Deluxe" required>
                        @error('product_name_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Field 2: Product Name (Tamil) -->
                    <div class="mb-3">
                        <label for="product_name_ta" class="form-label fw-bold">Product Name (Tamil) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg @error('product_name_ta') is-invalid @enderror" id="product_name_ta" name="product_name_ta" value="{{ old('product_name_ta') }}" placeholder="Example: பிளவர் பாட்ட்ஸ் டீலக்ஸ்" required>
                        @error('product_name_ta') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Field 3: Category -->
                    <div class="mb-3">
                        <label for="category_id" class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                        <select class="form-select form-select-lg @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                            <option value="">-- Choose Category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                    <h5 class="fw-bold mb-3 pb-2 border-bottom text-dark">
                        <i class="bi bi-tag text-success me-2"></i>Pricing & Inventory
                    </h5>

                    <!-- Field 4: Selling Price (₹) -->
                    <div class="mb-3">
                        <label for="price" class="form-label fw-bold">Selling Price (₹) <span class="text-danger">*</span></label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white">₹</span>
                            <input type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" placeholder="e.g. 120.50" required>
                        </div>
                        @error('price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <!-- Field 5: Stock Quantity -->
                    <div class="mb-3">
                        <label for="stock" class="form-label fw-bold">Stock Quantity <span class="text-danger">*</span></label>
                        <input type="number" min="0" class="form-control form-control-lg @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', 100) }}" placeholder="e.g. 50" required>
                        @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Field 6: Unit (Per Box) -->
                    <div class="mb-3">
                        <label for="unit" class="form-label fw-bold">Unit (Per Box) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg @error('unit') is-invalid @enderror" id="unit" name="unit" value="{{ old('unit', 'Box') }}" placeholder="e.g. Box, Piece, Packet" required>
                        @error('unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Below: Product Images -->
                <div class="col-12 border-top pt-4 mt-2">
                    <h5 class="fw-bold mb-3 text-dark">
                        <i class="bi bi-images text-warning me-2"></i>Product Images
                    </h5>
                    
                    <div class="row g-3">
                        <!-- Field 7: Main Product Image -->
                        <div class="col-md-6">
                            <label for="main_image" class="form-label fw-bold">Main Product Image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('main_image') is-invalid @enderror" id="main_image" name="main_image" accept="image/jpeg,image/png,image/jpg,image/webp" required>
                            <small class="text-muted">Primary image displayed on storefront and catalog.</small>
                            @error('main_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Field 8: Additional Images (Multiple Upload) -->
                        <div class="col-md-6">
                            <label for="gallery" class="form-label fw-bold">Additional Images (Multiple Upload)</label>
                            <input type="file" class="form-control @error('gallery.*') is-invalid @enderror" id="gallery" name="gallery[]" accept="image/jpeg,image/png,image/jpg,image/webp" multiple>
                            <small class="text-muted">Upload extra angles or product showcase photos.</small>
                            @error('gallery.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <!-- Bottom: Status & Save -->
                <div class="col-12 border-top pt-4 mt-2 d-flex justify-content-between align-items-center">
                    <!-- Field 9: Active Status (ON/OFF) -->
                    <div class="form-check form-switch fs-5 m-0">
                        <input class="form-check-input" type="checkbox" id="status" name="status" value="1" {{ old('status', 1) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold text-dark fs-6" for="status">Active Status (ON/OFF)</label>
                    </div>

                    <button type="submit" class="btn btn-danger btn-lg px-5 fw-bold shadow-sm">
                        <i class="bi bi-save me-1"></i> Save Product
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
