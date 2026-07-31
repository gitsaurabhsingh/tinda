<?php
$dir = __DIR__;
$adminDir = $dir . '/resources/views/admin/';

// 1. Redesign Layout
$layoutHtml = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Portal') - Tindablog</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { 
            font-family: 'Outfit', sans-serif; 
            background-color: #f3f4f6; 
            color: #1f2937; 
            overflow-x: hidden;
        }
        
        /* Premium Sidebar */
        .sidebar { 
            background: linear-gradient(180deg, #1e1b4b 0%, #312e81 100%);
            min-height: 100vh; 
            color: #e5e7eb; 
            padding: 30px 15px;
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
            position: fixed;
            width: 260px;
            z-index: 1000;
        }
        .sidebar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: #ffffff;
            text-align: center;
            margin-bottom: 40px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .sidebar .nav-link { 
            color: #9ca3af; 
            font-weight: 500;
            padding: 12px 20px; 
            border-radius: 12px;
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            transition: all 0.3s ease; 
        }
        .sidebar .nav-link i {
            width: 25px;
            font-size: 1.1rem;
            margin-right: 10px;
        }
        .sidebar .nav-link:hover { 
            background: rgba(255,255,255,0.1); 
            color: #ffffff; 
            transform: translateX(5px);
        }
        .sidebar .nav-link.active { 
            background: linear-gradient(90deg, #4f46e5, #6366f1); 
            color: white; 
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.4);
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            padding: 40px;
            width: calc(100% - 260px);
            min-height: 100vh;
        }

        /* Premium Cards */
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.1);
        }
        
        /* Modern Tables */
        .table {
            --bs-table-bg: transparent;
            vertical-align: middle;
        }
        .table thead th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0;
            padding: 15px;
        }
        .table tbody td {
            padding: 15px;
            border-bottom: 1px solid #f1f5f9;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            border: none;
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(59, 130, 246, 0.4);
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-brand">
                <i class="fa-solid fa-bolt text-warning me-2"></i> Tindablog
            </div>
            
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i> Dashboard
            </a>
            
            <a href="{{ route('admin.blogs.pending') }}" class="nav-link {{ request()->routeIs('admin.blogs.pending') ? 'active' : '' }}">
                <i class="fa-solid fa-clock-rotate-left"></i> Blogs (Pending)
            </a>
            
            <a href="{{ route('admin.blogs.create') }}" class="nav-link {{ request()->routeIs('admin.blogs.create') ? 'active' : '' }}">
                <i class="fa-solid fa-pen-nib"></i> Manage Blogs
            </a>
            
            <a href="{{ route('admin.categories') }}" class="nav-link {{ request()->routeIs('admin.categories') ? 'active' : '' }}">
                <i class="fa-solid fa-tags"></i> Categories
            </a>
            
            <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> Users
            </a>

            <div class="mt-4 mb-2 ps-3 text-uppercase" style="font-size: 0.75rem; color: #6b7280; font-weight: 700; letter-spacing: 1px;">Configuration</div>
            
            <a href="{{ route('admin.settings.hero') }}" class="nav-link {{ request()->routeIs('admin.settings.hero') ? 'active' : '' }}">
                <i class="fa-solid fa-image"></i> Hero Settings
            </a>
            
            <a href="{{ route('admin.settings.footer') }}" class="nav-link {{ request()->routeIs('admin.settings.footer') ? 'active' : '' }}">
                <i class="fa-solid fa-link"></i> Footer Settings
            </a>
            
            <a href="/" class="nav-link text-warning mt-5" target="_blank">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> View Live Site
            </a>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
    </div>
    
    <!-- FIX: Added Bootstrap JS bundle for collapse/dropdowns -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
HTML;
file_put_contents($adminDir . 'layout.blade.php', $layoutHtml);

// 2. Premium Dashboard Stats Cards
$dashboardHtml = <<<HTML
@extends('admin.layout')
@section('title', 'Admin Dashboard')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-5">
    <h2 class="fw-bold m-0 text-dark">Dashboard Overview</h2>
    <div class="text-muted"><i class="fa-regular fa-calendar me-2"></i> {{ date('F j, Y') }}</div>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="card h-100 p-4" style="background: linear-gradient(135deg, #eff6ff, #dbeafe);">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="text-primary fw-bold text-uppercase m-0">Total Blogs</h6>
                <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;"><i class="fa-solid fa-file-lines"></i></div>
            </div>
            <h2 class="display-5 fw-bold text-dark m-0">{{ \$stats['total_blogs'] }}</h2>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card h-100 p-4" style="background: linear-gradient(135deg, #fef2f2, #fee2e2);">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="text-danger fw-bold text-uppercase m-0">Pending Review</h6>
                <div class="bg-danger text-white rounded-circle d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;"><i class="fa-solid fa-triangle-exclamation"></i></div>
            </div>
            <h2 class="display-5 fw-bold text-dark m-0">{{ \$stats['pending_blogs'] }}</h2>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card h-100 p-4" style="background: linear-gradient(135deg, #f0fdfa, #ccfbf1);">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="text-teal fw-bold text-uppercase m-0" style="color: #0d9488;">Total Users</h6>
                <div class="text-white rounded-circle d-flex justify-content-center align-items-center" style="background-color: #0d9488; width: 40px; height: 40px;"><i class="fa-solid fa-users"></i></div>
            </div>
            <h2 class="display-5 fw-bold text-dark m-0">{{ \$stats['total_users'] }}</h2>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card h-100 p-4" style="background: linear-gradient(135deg, #fdf4ff, #fae8ff);">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="text-purple fw-bold text-uppercase m-0" style="color: #9333ea;">Comments</h6>
                <div class="text-white rounded-circle d-flex justify-content-center align-items-center" style="background-color: #9333ea; width: 40px; height: 40px;"><i class="fa-solid fa-comments"></i></div>
            </div>
            <h2 class="display-5 fw-bold text-dark m-0">{{ \$stats['total_comments'] }}</h2>
        </div>
    </div>
</div>
@endsection
HTML;
file_put_contents($adminDir . 'dashboard.blade.php', $dashboardHtml);

// 3. Fix blogs-create button structure
$blogsCreate = $adminDir . 'blogs-create.blade.php';
$blogsCreateHtml = file_get_contents($blogsCreate);
// Replace <button> with proper icon button
$blogsCreateHtml = str_replace(
    '<button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#addBlogCollapse">
        + Add New Blog
    </button>',
    '<button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#addBlogCollapse" aria-expanded="false" aria-controls="addBlogCollapse">
        <i class="fa-solid fa-plus me-2"></i> Add New Blog
    </button>',
    $blogsCreateHtml
);
file_put_contents($blogsCreate, $blogsCreateHtml);

echo "Premium redesign implemented.";
