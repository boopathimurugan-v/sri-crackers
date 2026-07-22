@extends('admin.layouts.app')

@section('title', 'Festival Offers')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Festival Offers</h2>
    <a href="{{ route('admin.festival-offers.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add Festival Offer
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
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Discount</th>
                        <th>Date Range</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($offers as $offer)
                    <tr>
                        <td>
                            @if($offer->image)
                                <img src="{{ Storage::url($offer->image) }}" alt="{{ $offer->title }}" class="img-thumbnail" style="height: 60px; object-fit: cover;">
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold">{{ $offer->title }}</div>
                            <small class="text-muted text-truncate d-inline-block" style="max-width: 200px;">{{ $offer->description }}</small>
                        </td>
                        <td><span class="badge bg-danger">{{ $offer->discount_percentage }}% OFF</span></td>
                        <td>
                            @if($offer->start_date && $offer->end_date)
                                {{ $offer->start_date->format('M d') }} - {{ $offer->end_date->format('M d, Y') }}
                            @else
                                <span class="text-muted">No specific date</span>
                            @endif
                        </td>
                        <td>
                            @if($offer->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.festival-offers.edit', $offer) }}" class="btn btn-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.festival-offers.destroy', $offer) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-delete" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">No festival offers found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-end mt-3">
            {{ $offers->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
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
