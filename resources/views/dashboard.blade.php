@extends('layouts.app')

@section('title', 'User Dashboard - ' . ($settings["site_name"] ?? "Tindablog"))

@section('content')
<style>
    /* Dashboard Specific Styles */
    .dashboard-wrapper {
        min-height: 80vh;
        background-color: #f8fafc;
        padding-top: 2rem;
        padding-bottom: 4rem;
    }
    
    /* Modern Sidebar */
    .dash-sidebar {
        background: white;
        border-radius: 24px;
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        position: sticky;
        top: 100px;
    }
    .dash-sidebar-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        padding: 30px 20px;
        text-align: center;
        color: white;
        position: relative;
    }
    .dash-sidebar-header::after {
        content: ''; position: absolute; bottom: -15px; left: 0; right: 0; height: 30px;
        background: white; border-radius: 50% 50% 0 0;
    }
    .profile-img-wrap {
        width: 90px; height: 90px;
        border-radius: 50%;
        padding: 4px;
        background: rgba(255,255,255,0.3);
        margin: 0 auto 15px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .profile-img-wrap img {
        width: 100%; height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid white;
    }
    .dash-nav-link {
        display: flex;
        align-items: center;
        padding: 14px 24px;
        color: #64748b;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }
    .dash-nav-link:hover {
        background: #f1f5f9;
        color: var(--primary);
    }
    .dash-nav-link.active {
        background: rgba(15, 42, 74, 0.05);
        color: var(--primary);
        border-left-color: var(--primary);
    }
    .dash-nav-link i {
        width: 24px;
        font-size: 1.1rem;
        margin-right: 12px;
        transition: transform 0.3s ease;
    }
    .dash-nav-link:hover i {
        transform: scale(1.1);
    }
    
    /* Stat Cards */
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.03);
        display: flex;
        align-items: center;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0,0,0,0.02);
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px -5px rgba(0,0,0,0.08);
    }
    .stat-icon {
        width: 60px; height: 60px;
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem;
        margin-right: 20px;
    }
    .icon-blue { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
    .icon-emerald { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .icon-amber { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    .icon-purple { background: rgba(139, 92, 246, 0.1); color: #8b5cf6; }
    
    /* Data Table */
    .dash-table-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    .table-custom { margin-bottom: 0; }
    .table-custom thead th {
        background: #f8fafc;
        color: #475569;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        padding: 16px 24px;
        border-bottom: 1px solid #e2e8f0;
    }
    .table-custom tbody td {
        padding: 20px 24px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }
    .table-custom tbody tr { transition: all 0.2s ease; }
    .table-custom tbody tr:hover { background: #f8fafc; }
    
    /* Blog Thumbnail */
    .blog-thumb {
        width: 60px; height: 50px;
        border-radius: 12px;
        object-fit: cover;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    
    /* Status Badges */
    .status-badge {
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .status-approved { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .status-pending { background: rgba(245, 158, 11, 0.1); color: #d97706; }
    .status-rejected { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
    
    /* Action Buttons */
    .btn-action {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: inline-flex; align-items: center; justify-content: center;
        transition: all 0.2s ease;
        border: none;
    }
    .btn-action-view { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
    .btn-action-view:hover { background: #3b82f6; color: white; transform: translateY(-2px); }
    .btn-action-edit { background: rgba(139, 92, 246, 0.1); color: #8b5cf6; }
    .btn-action-edit:hover { background: #8b5cf6; color: white; transform: translateY(-2px); }
    .btn-action-delete { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
    .btn-action-delete:hover { background: #ef4444; color: white; transform: translateY(-2px); }
</style>

<div class="dashboard-wrapper">
    <div class="container">
        
        <!-- Welcome Header -->
        <div class="d-flex justify-content-between align-items-end mb-4" data-aos="fade-down">
            <div>
                <h2 class="fw-bolder text-dark mb-1">Welcome back, {{ explode(' ', Auth::user()->name)[0] }}! <span class="fs-4">👋</span></h2>
                <p class="text-muted mb-0">Here's what's happening with your articles today.</p>
            </div>
            <a href="{{ route('user.blogs.create') }}" class="btn btn-primary shadow-sm rounded-pill px-4 py-2 d-none d-md-flex align-items-center">
                <i class="fa-solid fa-plus me-2"></i> Create New Blog
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success rounded-4 border-0 shadow-sm d-flex align-items-center p-3 mb-4" data-aos="fade-in">
                <i class="fa-solid fa-circle-check fs-4 text-success me-3"></i>
                <div class="fw-medium">{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- Left Sidebar -->
            <div class="col-lg-3" data-aos="fade-right">
                <div class="dash-sidebar">
                    <div class="dash-sidebar-header">
                        <div class="profile-img-wrap">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0f2a4a&color=fff&size=128" alt="Profile" loading="lazy" width="128" height="128">
                        </div>
                        <h5 class="fw-bold mb-0 text-white">{{ Auth::user()->name }}</h5>
                        <p class="small text-white-50 mb-0">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="py-3">
                        <a href="{{ route('dashboard') }}" class="dash-nav-link active">
                            <i class="fa-solid fa-gauge"></i> Overview
                        </a>
                        <a href="{{ route('user.blogs.create') }}" class="dash-nav-link">
                            <i class="fa-solid fa-pen-nib"></i> Write Article
                        </a>
                        <a href="{{ route('profile.edit') }}" class="dash-nav-link">
                            <i class="fa-solid fa-gear"></i> Settings
                        </a>
                        <hr class="mx-4 my-2 opacity-10">
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="dash-nav-link w-100 text-start bg-transparent border-0 text-danger" style="border-left: 3px solid transparent;">
                                <i class="fa-solid fa-right-from-bracket text-danger"></i> Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                
                @php
                    $totalBlogs = $blogs->count();
                    $approvedBlogs = $blogs->where('status', 'approved')->count();
                    $pendingBlogs = $blogs->whereIn('status', ['pending', 'rejected'])->count();
                    $totalViews = $blogs->sum('views');
                @endphp

                <!-- Statistics Grid -->
                <div class="row g-3 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-md-3 col-sm-6">
                        <div class="stat-card">
                            <div class="stat-icon icon-blue"><i class="fa-solid fa-file-lines"></i></div>
                            <div>
                                <h3 class="fw-bolder mb-0">{{ $totalBlogs }}</h3>
                                <p class="text-muted small fw-bold text-uppercase mb-0">Total Blogs</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="stat-card">
                            <div class="stat-icon icon-purple"><i class="fa-solid fa-eye"></i></div>
                            <div>
                                <h3 class="fw-bolder mb-0">{{ number_format($totalViews) }}</h3>
                                <p class="text-muted small fw-bold text-uppercase mb-0">Total Views</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="stat-card">
                            <div class="stat-icon icon-emerald"><i class="fa-solid fa-check-circle"></i></div>
                            <div>
                                <h3 class="fw-bolder mb-0">{{ $approvedBlogs }}</h3>
                                <p class="text-muted small fw-bold text-uppercase mb-0">Published</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="stat-card">
                            <div class="stat-icon icon-amber"><i class="fa-solid fa-clock"></i></div>
                            <div>
                                <h3 class="fw-bolder mb-0">{{ $pendingBlogs }}</h3>
                                <p class="text-muted small fw-bold text-uppercase mb-0">Pending</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Articles Table -->
                <div class="dash-table-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h5 class="fw-bold mb-0">Your Articles</h5>
                        <a href="{{ route('user.blogs.create') }}" class="btn btn-sm btn-outline-primary rounded-pill d-md-none">New</a>
                    </div>
                    
                    @if($blogs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-custom">
                                <thead>
                                    <tr>
                                        <th>Article Details</th>
                                        <th>Category</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($blogs as $blog)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $blog->featured_image }}" class="blog-thumb me-3" alt="{{ $blog->title }}" loading="lazy" width="60" height="60">
                                                <div>
                                                    <h6 class="fw-bold mb-1 text-dark" style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $blog->title }}</h6>
                                                    <div class="text-muted small"><i class="fa-regular fa-eye me-1"></i> {{ number_format($blog->views ?? 0) }} Views</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border px-2 py-1 rounded-pill">{{ $blog->categories->first()->name ?? 'Uncategorized' ?? 'General' }}</span>
                                        </td>
                                        <td class="text-muted small fw-medium">
                                            {{ $blog->created_at->format('M d, Y') }}
                                        </td>
                                        <td>
                                            @if($blog->status === 'approved')
                                                <span class="status-badge status-approved"><i class="fa-solid fa-check"></i> Published</span>
                                            @elseif($blog->status === 'rejected')
                                                <span class="status-badge status-rejected"><i class="fa-solid fa-xmark"></i> Rejected</span>
                                            @else
                                                <span class="status-badge status-pending"><i class="fa-solid fa-spinner fa-spin-pulse"></i> Pending</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="{{ route('page.show', $blog->slug) }}" class="btn-action btn-action-view {{ $blog->status !== 'approved' ? 'opacity-50 pe-none' : '' }}" title="View Public Post">
                                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                                </a>
                                                <a href="{{ route('user.blogs.edit', $blog->id) }}" class="btn-action btn-action-edit" title="Edit Article">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                                <form action="{{ route('user.blogs.destroy', $blog->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this article?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-action btn-action-delete" title="Delete Article">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle" style="width: 100px; height: 100px;">
                                    <i class="fa-solid fa-feather display-4 text-primary opacity-50"></i>
                                </div>
                            </div>
                            <h4 class="fw-bold">No Articles Yet</h4>
                            <p class="text-muted mx-auto mb-4" style="max-width: 400px;">You haven't published any articles. Share your thoughts and stories with the world by writing your first blog post!</p>
                            <a href="{{ route('user.blogs.create') }}" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm">
                                <i class="fa-solid fa-pen-nib me-2"></i> Start Writing
                            </a>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
