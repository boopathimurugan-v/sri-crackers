@extends('admin.layouts.app')

@section('title', 'Category Details - ' . $category->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Category Details</h2>
    <div>
        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary me-2">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Categories
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0">
                @if($category->image)
                    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="img-fluid rounded border shadow-sm w-100">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center rounded border w-100" style="min-height: 250px;">
                        <div class="text-center text-muted">
                            <i class="bi bi-image fs-1 mb-2"></i>
                            <p class="mb-0">No image available</p>
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="col-md-8">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 30%">ID</th>
                            <td>{{ $category->id }}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{ $category->name }}</td>
                        </tr>
                        <tr>
                            <th>Slug</th>
                            <td><code>{{ $category->slug }}</code></td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{{ $category->description ?: 'No description provided.' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($category->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $category->created_at->format('M d, Y h:i A') }}</td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>{{ $category->updated_at->format('M d, Y h:i A') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
