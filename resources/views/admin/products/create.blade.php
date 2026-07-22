@extends('admin.layouts.app')

@section('title', 'Create Product')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Create Product</h2>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Products
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <!-- Basic Info -->
                <div class="col-md-8">
                    <h5 class="mb-3 border-bottom pb-2">Basic Information</h5>
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="brand" class="form-label">Brand</label>
                            <input type="text" class="form-control @error('brand') is-invalid @enderror" id="brand" name="brand" value="{{ old('brand') }}">
                            @error('brand') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short Description</label>
                        <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description" name="short_description" rows="2">{{ old('short_description') }}</textarea>
                        @error('short_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="long_description" class="form-label">Long Description</label>
                        <textarea class="form-control @error('long_description') is-invalid @enderror" id="long_description" name="long_description" rows="5">{{ old('long_description') }}</textarea>
                        @error('long_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                
                <!-- Pricing & Inventory -->
                <div class="col-md-4">
                    <h5 class="mb-3 border-bottom pb-2">Pricing & Inventory</h5>
                    
                    <div class="mb-3">
                        <label for="mrp" class="form-label">MRP (₹) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('mrp') is-invalid @enderror" id="mrp" name="mrp" value="{{ old('mrp') }}" required>
                        @error('mrp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="offer_price" class="form-label">Offer Price (₹) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('offer_price') is-invalid @enderror" id="offer_price" name="offer_price" value="{{ old('offer_price') }}" required>
                        @error('offer_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="gst" class="form-label">GST (%)</label>
                        <input type="number" step="0.01" class="form-control @error('gst') is-invalid @enderror" id="gst" name="gst" value="{{ old('gst', 0) }}">
                        @error('gst') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="stock" class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', 0) }}" required>
                            @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="unit" class="form-label">Unit (Per Box)</label>
                            <input type="text" class="form-control @error('unit') is-invalid @enderror" id="unit" name="unit" value="{{ old('unit') }}" placeholder="e.g., 5 Pieces">
                            @error('unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="sku" class="form-label">SKU</label>
                        <input type="text" class="form-control @error('sku') is-invalid @enderror" id="sku" name="sku" value="{{ old('sku') }}">
                        @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="weight" class="form-label">Weight (kg)</label>
                        <input type="number" step="0.01" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight') }}">
                        @error('weight') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="row">
                <!-- Images -->
                <div class="col-md-8">
                    <h5 class="mb-3 border-bottom pb-2">Images</h5>
                    
                    <div class="mb-4">
                        <label for="main_image" class="form-label">Main Product Image</label>
                        <input type="file" class="form-control @error('main_image') is-invalid @enderror" id="main_image" name="main_image" accept="image/*" onchange="previewMainImage(this)">
                        <div class="form-text">Recommended size: 800x800px. Max size: 2MB.</div>
                        @error('main_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        
                        <div class="mt-2 d-none" id="mainImagePreviewContainer">
                            <img id="mainImagePreview" src="#" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="gallery" class="form-label">Gallery Images (Multiple)</label>
                        <input type="file" class="form-control @error('gallery.*') is-invalid @enderror" id="gallery" name="gallery[]" accept="image/*" multiple onchange="previewGalleryImages(this)">
                        <div class="form-text">You can select multiple images. Max size: 2MB per image.</div>
                        @error('gallery.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        
                        <div class="mt-2 row g-2" id="galleryImagesPreviewContainer"></div>
                    </div>
                </div>
                
                <!-- Status & Options -->
                <div class="col-md-4">
                    <h5 class="mb-3 border-bottom pb-2">Options</h5>
                    
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="status" name="status" value="1" {{ old('status', '1') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">Active Status</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_available" name="is_available" value="1" {{ old('is_available', '1') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_available">Available for Purchase</label>
                            <div class="form-text small text-muted">Overrides stock. If disabled, product cannot be added to cart.</div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" {{ old('featured') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="featured">Featured Product</label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="trending" name="trending" value="1" {{ old('trending') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="trending">Trending Product</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="display_order" class="form-label">Display Order</label>
                        <input type="number" class="form-control @error('display_order') is-invalid @enderror" id="display_order" name="display_order" value="{{ old('display_order', 0) }}">
                        @error('display_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            
            <div class="mt-4 pt-3 border-top d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-save"></i> Save Product</button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewMainImage(input) {
        const container = document.getElementById('mainImagePreviewContainer');
        const preview = document.getElementById('mainImagePreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            container.classList.add('d-none');
            preview.src = '#';
        }
    }

    function previewGalleryImages(input) {
        const container = document.getElementById('galleryImagesPreviewContainer');
        container.innerHTML = '';
        
        if (input.files) {
            Array.from(input.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-auto';
                    col.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="height: 100px; width: 100px; object-fit: cover;">`;
                    container.appendChild(col);
                }
                reader.readAsDataURL(file);
            });
        }
    }
</script>
@endsection
