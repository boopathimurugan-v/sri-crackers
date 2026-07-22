@extends('admin.layouts.app')

@section('title', 'Newsletter Subscribers')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800">Newsletter Subscribers</h2>
    <div>
        <span class="badge bg-primary fs-6 px-3 py-2 rounded-pill shadow-sm">
            Total Active: {{ \App\Models\Newsletter::where('is_subscribed', true)->count() }}
        </span>
    </div>
</div>

<div class="card shadow mb-4 border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Email Address</th>
                        <th>Subscribed Date</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscribers as $subscriber)
                    <tr>
                        <td class="ps-4 fw-bold text-dark">{{ $subscriber->email }}</td>
                        <td class="text-muted">{{ $subscriber->created_at->format('M d, Y h:i A') }}</td>
                        <td>
                            @if($subscriber->is_subscribed)
                                <span class="badge bg-success rounded-pill px-3 py-2 small">Active</span>
                            @else
                                <span class="badge bg-secondary rounded-pill px-3 py-2 small">Unsubscribed</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <form action="{{ route('admin.newsletters.destroy', $subscriber) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Remove this subscriber permanently?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Remove">
                                    <i class="bi bi-trash"></i> Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="bi bi-envelope-paper fs-1 d-block mb-3"></i>
                            No subscribers found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($subscribers->hasPages())
    <div class="card-footer bg-white border-0 py-3">
        {{ $subscribers->links() }}
    </div>
    @endif
</div>
@endsection
