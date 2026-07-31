@extends('admin.layout')
@section('title', 'Contact Messages')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0 text-dark">Contact Messages</h2>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3 text-secondary fw-bold border-0">Sender</th>
                        <th class="px-4 py-3 text-secondary fw-bold border-0">Message</th>
                        <th class="px-4 py-3 text-secondary fw-bold border-0">Date</th>
                        <th class="px-4 py-3 text-secondary fw-bold border-0 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($messages as $msg)
                    <tr class="{{ $msg->is_read ? '' : 'bg-primary bg-opacity-10' }}">
                        <td class="px-4 py-3">
                            <div class="fw-bold">{{ $msg->name }}</div>
                            <div class="text-muted small">{{ $msg->email }}</div>
                        </td>
                        <td class="px-4 py-3" style="max-width: 300px;">
                            <div class="fw-bold text-truncate">{{ $msg->subject ?? 'No Subject' }}</div>
                            <div class="text-muted small text-truncate">{{ Str::limit($msg->message, 80) }}</div>
                        </td>
                        <td class="px-4 py-3 text-muted small">
                            {{ $msg->created_at->diffForHumans() }}
                        </td>
                        <td class="px-4 py-3 text-end">
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-2" data-bs-toggle="modal" data-bs-target="#viewMessageModal{{ $msg->id }}">
                                View
                            </button>
                            <form action="{{ route('admin.contacts.destroy', $msg->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Delete this message?')">Delete</button>
                            </form>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-5 text-center text-muted">
                            <div class="mb-3"><i class="fa-solid fa-envelope-open text-light fs-1"></i></div>
                            No messages received yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Modals for View Message (Placed OUTSIDE the table for valid HTML) -->
        @foreach($messages as $msg)
        <div class="modal fade" id="viewMessageModal{{ $msg->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 border-0 shadow">
                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="modal-title fw-bold">Message Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <div class="text-muted small fw-bold text-uppercase mb-1">From</div>
                            <div><strong>{{ $msg->name }}</strong> (<a href="mailto:{{ $msg->email }}">{{ $msg->email }}</a>)</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-muted small fw-bold text-uppercase mb-1">Subject</div>
                            <div class="fw-bold fs-5">{{ $msg->subject ?? 'No Subject' }}</div>
                        </div>
                        <div class="mb-4 bg-light rounded p-3" style="white-space: pre-wrap;">{{ $msg->message }}</div>
                        
                        @if(!$msg->is_read)
                        <form action="{{ route('admin.contacts.read', $msg->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100 rounded-pill">Mark as Read</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @if($messages->hasPages())
        <div class="card-footer bg-white border-top p-4">
            {{ $messages->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
