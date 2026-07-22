@extends('admin.layouts.app')

@section('title', 'Payment History')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800">Payment History</h2>
</div>

<div class="card shadow mb-4 border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Trans ID</th>
                        <th>Order</th>
                        <th>Method</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $txn)
                    <tr>
                        <td class="ps-4">
                            <span class="font-monospace fw-bold text-muted">{{ $txn->transaction_ref ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $txn->order) }}" class="fw-bold text-decoration-none">
                                {{ $txn->order->order_number }}
                            </a>
                        </td>
                        <td>
                            <span class="text-uppercase fw-bold text-secondary" style="font-size: 0.8rem;">
                                {{ $txn->payment_method }}
                            </span>
                        </td>
                        <td>
                            <span class="fw-bold">₹{{ number_format($txn->amount, 2) }}</span>
                        </td>
                        <td>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-warning text-dark',
                                    'success' => 'bg-success text-white',
                                    'failed' => 'bg-danger text-white',
                                ];
                                $badgeClass = $statusColors[$txn->status] ?? 'bg-secondary text-white';
                            @endphp
                            <span class="badge {{ $badgeClass }} rounded-pill px-3 py-2 text-uppercase" style="font-size: 0.7rem; tracking: 1px;">
                                {{ $txn->status }}
                            </span>
                        </td>
                        <td>{{ $txn->created_at->format('M d, Y h:i A') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-wallet2 fs-1 d-block mb-3"></i>
                            No transactions found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($transactions->hasPages())
    <div class="card-footer bg-white border-0 py-3">
        {{ $transactions->links() }}
    </div>
    @endif
</div>
@endsection
