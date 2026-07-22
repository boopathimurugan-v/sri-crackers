@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Categories</h2>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add Category
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
        <form action="{{ route('admin.categories.index') }}" method="GET" class="row g-3 mb-3">
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search categories..." name="search" value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </div>
            <div class="col-md-auto ms-auto">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-light">Clear</a>
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
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td>
                            @if($category->image)
                                <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded" style="width: 50px; height: 50px;">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif
                        </td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>
                            <form action="{{ route('admin.categories.toggle-status', $category) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-{{ $category->status ? 'success' : 'secondary' }}">
                                    {{ $category->status ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-info text-white" title="View"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-delete" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">No categories found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-end mt-3">
            {{ $categories->links('pagination::bootstrap-5') }}
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
