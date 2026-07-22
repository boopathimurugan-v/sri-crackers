@extends('admin.layouts.app')

@section('title', 'Inquiry Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800">Inquiry Details</h2>
    <a href="{{ route('admin.contacts.index') }}" class="btn btn-light border shadow-sm">
        <i class="bi bi-arrow-left"></i> Back to Inquiries
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white pt-4 pb-3 px-4 border-bottom-0">
                <h4 class="mb-1 fw-bold">{{ $contact->subject }}</h4>
                <div class="text-muted small">
                    Received on {{ $contact->created_at->format('l, F j, Y \a\t h:i A') }}
                </div>
            </div>
            <div class="card-body p-4 bg-light rounded-bottom">
                <div class="bg-white p-4 rounded shadow-sm border" style="min-height: 200px; white-space: pre-wrap;">{{ $contact->message }}</div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3 text-uppercase text-muted" style="letter-spacing: 1px;">Customer Details</h6>
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 fs-4" style="width: 50px; height: 50px;">
                        {{ strtoupper(substr($contact->name, 0, 1)) }}
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">{{ $contact->name }}</h5>
                    </div>
                </div>
                
                <hr>
                
                <div class="mb-3">
                    <label class="text-muted small fw-bold text-uppercase d-block mb-1">Email Address</label>
                    <a href="mailto:{{ $contact->email }}" class="text-decoration-none fw-bold">{{ $contact->email }}</a>
                </div>
                
                <hr>

                <div class="d-grid gap-2 mt-4">
                    <a href="mailto:{{ $contact->email }}?subject=RE: {{ urlencode($contact->subject) }}" class="btn btn-primary py-2 fw-bold">
                        <i class="bi bi-reply-fill"></i> Reply via Email
                    </a>
                    
                    <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this inquiry?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100 py-2 fw-bold">
                            <i class="bi bi-trash"></i> Delete Inquiry
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
