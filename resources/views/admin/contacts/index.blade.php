@extends('admin.layouts.app')

@section('title', 'Manage Inquiries')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800">Contact Inquiries</h2>
</div>

<div class="card shadow mb-4 border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Date</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $contact)
                    <tr class="{{ !$contact->is_read ? 'bg-light fw-bold' : '' }}">
                        <td class="ps-4 text-muted small">{{ $contact->created_at->format('M d, Y') }}</td>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>
                            <span class="d-inline-block text-truncate" style="max-width: 200px;">
                                {{ $contact->subject }}
                            </span>
                        </td>
                        <td>
                            @if($contact->is_read)
                                <span class="badge bg-secondary rounded-pill px-3 py-2 small">Read</span>
                            @else
                                <span class="badge bg-primary rounded-pill px-3 py-2 small">New</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-sm btn-light border me-1" title="View Details">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this inquiry?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                            No inquiries found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($contacts->hasPages())
    <div class="card-footer bg-white border-0 py-3">
        {{ $contacts->links() }}
    </div>
    @endif
</div>
@endsection
