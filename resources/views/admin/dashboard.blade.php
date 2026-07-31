@extends('admin.layout')
@section('title', 'Admin Dashboard')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-5">
    <h2 class="fw-bold m-0 text-dark">Dashboard Overview</h2>
    <div class="text-muted"><i class="fa-regular fa-calendar me-2"></i> {{ date('F j, Y') }}</div>
</div>

<!-- Primary Stats Row -->
<div class="row g-4 mb-4">
    <!-- Website Visits Today -->
    <div class="col-md-3">
        <div class="card h-100 p-4 border-0" style="background: linear-gradient(135deg, #f0fdfa, #ccfbf1); box-shadow: 0 10px 20px rgba(13, 148, 136, 0.1);">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="text-teal fw-bold text-uppercase m-0" style="color: #0d9488;">Today's Visits</h6>
                <div class="text-white rounded-circle d-flex justify-content-center align-items-center shadow-sm" style="background-color: #0d9488; width: 40px; height: 40px;"><i class="fa-solid fa-users-viewfinder"></i></div>
            </div>
            <h2 class="display-5 fw-bold text-dark m-0">{{ number_format($stats['today_visits']) }}</h2>
            <div class="mt-2 small text-muted">Unique IP visits today</div>
        </div>
    </div>

    <!-- Total Blog Views -->
    <div class="col-md-3">
        <div class="card h-100 p-4 border-0" style="background: linear-gradient(135deg, #eff6ff, #dbeafe); box-shadow: 0 10px 20px rgba(59, 130, 246, 0.1);">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="text-primary fw-bold text-uppercase m-0">Total Blog Views</h6>
                <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center shadow-sm" style="width: 40px; height: 40px;"><i class="fa-solid fa-eye"></i></div>
            </div>
            <h2 class="display-5 fw-bold text-dark m-0">{{ number_format($stats['total_views']) }}</h2>
            <div class="mt-2 small text-muted">Across all published blogs</div>
        </div>
    </div>
    
    <!-- Total Blogs -->
    <div class="col-md-3">
        <div class="card h-100 p-4 border-0" style="background: linear-gradient(135deg, #fdf4ff, #fae8ff); box-shadow: 0 10px 20px rgba(147, 51, 234, 0.1);">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="text-purple fw-bold text-uppercase m-0" style="color: #9333ea;">Total Blogs</h6>
                <div class="text-white rounded-circle d-flex justify-content-center align-items-center shadow-sm" style="background-color: #9333ea; width: 40px; height: 40px;"><i class="fa-solid fa-file-lines"></i></div>
            </div>
            <h2 class="display-5 fw-bold text-dark m-0">{{ number_format($stats['total_blogs']) }}</h2>
            <div class="mt-2 small text-muted">{{ $stats['pending_blogs'] }} pending review</div>
        </div>
    </div>

    <!-- Total Visits Overall -->
    <div class="col-md-3">
        <div class="card h-100 p-4 border-0" style="background: linear-gradient(135deg, #fffbeb, #fef3c7); box-shadow: 0 10px 20px rgba(217, 119, 6, 0.1);">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="text-warning fw-bold text-uppercase m-0" style="color: #d97706 !important;">Total Visits</h6>
                <div class="text-white rounded-circle d-flex justify-content-center align-items-center shadow-sm" style="background-color: #d97706; width: 40px; height: 40px;"><i class="fa-solid fa-globe"></i></div>
            </div>
            <h2 class="display-5 fw-bold text-dark m-0">{{ number_format($stats['total_visits']) }}</h2>
            <div class="mt-2 small text-muted">All-time unique visits</div>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    <!-- Top Blogs Chart/List -->
    <div class="col-lg-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                <h5 class="fw-bold m-0"><i class="fa-solid fa-fire text-danger me-2"></i> Most Viewed Blogs</h5>
            </div>
            <div class="card-body p-4">
                @forelse($topBlogs as $blog)
                <div class="d-flex align-items-center mb-3 pb-3 border-bottom border-light">
                    @if($blog->featured_image && Str::startsWith($blog->featured_image, 'http'))
                        <img src="{{ $blog->featured_image }}" alt="{{ $blog->title ?? 'Blog Image' }}" loading="lazy" width="60" height="60" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                    @elseif($blog->featured_image)
                        <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title ?? 'Blog Image' }}" loading="lazy" width="60" height="60" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                    @else
                        <div class="bg-light rounded d-flex justify-content-center align-items-center text-muted" style="width: 60px; height: 60px;">
                            <i class="fa-solid fa-image"></i>
                        </div>
                    @endif
                    <div class="ms-3 flex-grow-1">
                        <h6 class="fw-bold mb-1 text-truncate" style="max-width: 250px;">{{ $blog->title }}</h6>
                        <span class="badge bg-light text-dark border"><i class="fa-solid fa-eye me-1"></i> {{ number_format($blog->views) }} views</span>
                    </div>
                    <div>
                        <a href="{{ route('page.show', $blog->slug) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle"><i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-4">No published blogs yet.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Visitors Tracker -->
    <div class="col-lg-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                <h5 class="fw-bold m-0"><i class="fa-solid fa-map-location-dot text-primary me-2"></i> Recent Visitors (Live)</h5>
            </div>
            <div class="card-body p-0 mt-3">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Country</th>
                                <th>IP Address</th>
                                <th class="text-end pe-4">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentVisitors as $visitor)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        @if($visitor->country == 'Localhost' || $visitor->country == 'Unknown')
                                            <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;"><i class="fa-solid fa-globe"></i></div>
                                            <span class="fw-medium text-muted">{{ $visitor->country }}</span>
                                        @else
                                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;"><i class="fa-solid fa-location-dot"></i></div>
                                            <span class="fw-bold">{{ $visitor->country }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border font-monospace">{{ $visitor->ip_address }}</span>
                                </td>
                                <td class="text-end pe-4 text-muted small">
                                    {{ $visitor->created_at->diffForHumans() }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">No visitors logged yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
