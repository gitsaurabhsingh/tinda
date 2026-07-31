@extends('admin.layout')
@section('title', 'Subscribers')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0">Newsletter Subscribers</h2>
</div>

@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Email Address</th>
                        <th>Subscribed On</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscribers as $subscriber)
                    <tr>
                        <td class="ps-4 fw-bold">{{ $subscriber->email }}</td>
                        <td>{{ $subscriber->created_at->format('M d, Y h:i A') }}</td>
                        <td><span class="badge bg-success">{{ $subscriber->status ?? 'active' }}</span></td>
                        <td class="text-end pe-4">
                            <form action="{{ route('admin.subscribers.destroy', $subscriber->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this subscriber?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-users fs-1 mb-3 opacity-25"></i><br>
                            No subscribers found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-4">
    {{ $subscribers->links() }}
</div>
@endsection
