@extends('admin.layouts.app')

@section('title', 'Create Festival Offer')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Create Festival Offer</h2>
    <a href="{{ route('admin.festival-offers.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.festival-offers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="title" class="form-label">Offer Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}">
                            @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}">
                            @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="discount_percentage" class="form-label">Discount Percentage (%) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('discount_percentage') is-invalid @enderror" id="discount_percentage" name="discount_percentage" value="{{ old('discount_percentage', 0) }}" required>
                        @error('discount_percentage') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                        @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="status" name="status" value="1" {{ old('status', '1') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">Active Status</label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">Offer Image <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" onchange="previewImage(this)" required>
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        
                        <div class="mt-2 d-none" id="imagePreviewContainer">
                            <img id="imagePreview" src="#" alt="Preview" class="img-fluid rounded border shadow-sm">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 text-end border-top pt-3">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save Festival Offer</button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        const container = document.getElementById('imagePreviewContainer');
        const preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
