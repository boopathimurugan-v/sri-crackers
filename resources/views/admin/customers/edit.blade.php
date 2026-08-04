@extends('admin.layouts.app')

@section('title', 'Edit Customer - ' . $customer->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0">Edit Customer Profile</h2>
    <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Back to Customers
    </a>
</div>

<div class="card shadow-sm max-w-xl">
    <div class="card-body">
        <form action="{{ route('admin.customers.update', $customer) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-12">
                    <label for="name" class="form-label">Customer Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $customer->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $customer->email) }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="phone" class="form-label">Mobile Number</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $customer->phone) }}" placeholder="e.g. 9876543210">
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12 mt-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_blocked" name="is_blocked" value="1" {{ old('is_blocked', $customer->is_blocked) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold text-danger" for="is_blocked">Block Account (Customer cannot log in or place orders)</label>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Update Customer</button>
            </div>
        </form>
    </div>
</div>
@endsection
