<?php
$routesFile = __DIR__ . '/routes/web.php';
$routesContent = <<<PHP
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/category/{slug}', [BlogController::class, 'category'])->name('blog.category');

require __DIR__.'/auth.php';
PHP;
file_put_contents($routesFile, $routesContent);

$viewsDir = __DIR__ . '/resources/views/';
if (!is_dir($viewsDir . 'layouts')) mkdir($viewsDir . 'layouts', 0777, true);
if (!is_dir($viewsDir . 'pages')) mkdir($viewsDir . 'pages', 0777, true);

$layoutContent = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tindablog - Premium Blogging')</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; color: #1E293B; }
        .navbar { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .hero { background: linear-gradient(135deg, #2563EB, #0F172A); color: white; padding: 100px 0; border-radius: 0 0 50px 50px; margin-bottom: 40px; }
        .btn-primary { background-color: #2563EB; border-color: #2563EB; border-radius: 30px; padding: 10px 25px; }
        .btn-accent { background-color: #F97316; border-color: #F97316; border-radius: 30px; padding: 10px 25px; color: white; }
        .blog-card { background: white; border-radius: 20px; border: none; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); transition: transform 0.3s; }
        .blog-card:hover { transform: translateY(-5px); }
        .footer { background: #0F172A; color: #cbd5e1; padding: 50px 0; border-radius: 50px 50px 0 0; margin-top: 50px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary fs-3" href="/">Tindablog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link fw-medium" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium" href="#">Categories</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium" href="#">Trending</a></li>
                </ul>
                <div class="d-flex ms-lg-3 mt-3 mt-lg-0">
                    <a href="/login" class="btn btn-outline-primary me-2 rounded-pill">Login</a>
                    <a href="/register" class="btn btn-primary rounded-pill">Sign Up</a>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="footer">
        <div class="container text-center">
            <h4 class="fw-bold text-white mb-3">Tindablog</h4>
            <p>Premium modern blogging platform built with Laravel 12.</p>
            <p class="mb-0">&copy; 2026 Tindablog. All rights reserved.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
HTML;
file_put_contents($viewsDir . 'layouts/app.blade.php', $layoutContent);

$homeContent = <<<HTML
@extends('layouts.app')

@section('title', 'Tindablog - Home')

@section('content')
<section class="hero text-center text-white">
    <div class="container">
        <h1 class="display-4 fw-bold mb-4">Welcome to Tindablog</h1>
        <p class="lead mb-5 opacity-75">Discover premium articles on technology, lifestyle, and business.</p>
        <a href="#" class="btn btn-accent btn-lg fw-semibold shadow-sm">Start Reading</a>
    </div>
</section>

<div class="container py-5">
    <h2 class="fw-bold mb-4">Latest Blogs</h2>
    <div class="row g-4">
        @for(\$i=1; \$i<=6; \$i++)
        <div class="col-md-4">
            <div class="card blog-card h-100">
                <img src="https://picsum.photos/seed/{\$i}/400/250" class="card-img-top" alt="Blog Image" style="border-radius: 20px 20px 0 0; object-fit: cover; height: 200px;">
                <div class="card-body">
                    <span class="badge bg-primary mb-2 rounded-pill">Technology</span>
                    <h5 class="card-title fw-bold">How to Learn Laravel 12 in 2026</h5>
                    <p class="card-text text-muted">A complete guide to mastering the latest version of Laravel and building modern web apps...</p>
                    <a href="#" class="text-primary text-decoration-none fw-semibold">Read More &rarr;</a>
                </div>
            </div>
        </div>
        @endfor
    </div>
</div>
@endsection
HTML;
file_put_contents($viewsDir . 'welcome.blade.php', $homeContent); // Overwrite default welcome

echo "Views and routes setup completed.";
