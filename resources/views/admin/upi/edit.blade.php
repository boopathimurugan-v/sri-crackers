@extends('admin.layouts.app')

@section('title', 'Edit UPI Account')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0">Edit UPI Account: {{ $upi->name }}</h2>
    <a href="{{ route('admin.upi.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to UPI Accounts
    </a>
</div>

<div class="card shadow-sm max-w-2xl">
    <div class="card-body">
        <form action="{{ route('admin.upi.update', $upi) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Account Label / Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $upi->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="account_holder_name" class="form-label">Account Holder Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('account_holder_name') is-invalid @enderror" id="account_holder_name" name="account_holder_name" value="{{ old('account_holder_name', $upi->account_holder_name) }}" required>
                    @error('account_holder_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="upi_id" class="form-label">UPI ID <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('upi_id') is-invalid @enderror" id="upi_id" name="upi_id" value="{{ old('upi_id', $upi->upi_id) }}" required>
                    @error('upi_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="daily_limit" class="form-label">Daily Limit (₹) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('daily_limit') is-invalid @enderror" id="daily_limit" name="daily_limit" value="{{ old('daily_limit', $upi->daily_limit) }}" required>
                    @error('daily_limit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="display_order" class="form-label">Rotation Order Priority</label>
                    <input type="number" class="form-control @error('display_order') is-invalid @enderror" id="display_order" name="display_order" value="{{ old('display_order', $upi->display_order) }}">
                    <div class="form-text">Lower number means higher priority.</div>
                    @error('display_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="qr_image" class="form-label">UPI QR Code Image</label>
                    <input type="file" class="form-control @error('qr_image') is-invalid @enderror" id="qr_image" name="qr_image" accept="image/*">
                    @if($upi->qr_image && file_exists(public_path('storage/' . $upi->qr_image)))
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $upi->qr_image) }}" alt="Current QR" class="img-thumbnail" style="max-height: 100px;">
                        </div>
                    @endif
                    @error('qr_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12 mt-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $upi->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="is_active">Enable / Active Status</label>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Update UPI Account</button>
            </div>
        </form>
    </div>
</div>
@endsection
