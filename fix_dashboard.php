<?php
$routesFile = __DIR__ . '/routes/web.php';
$routesContent = file_get_contents($routesFile);

if (!str_contains($routesContent, "name('dashboard')")) {
    $dashboardRoute = <<<PHP

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
PHP;
    file_put_contents($routesFile, $dashboardRoute, FILE_APPEND);
}

$dashboardViewFile = __DIR__ . '/resources/views/dashboard.blade.php';
$dashboardContent = <<<HTML
@extends('layouts.app')

@section('title', 'User Dashboard - Tindablog')

@section('content')
<div class="container py-5 mt-4" style="min-height: 70vh;">
    <div class="row">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body text-center p-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=2563EB&color=fff" class="rounded-circle mb-3" width="100" height="100">
                    <h5 class="fw-bold mb-1">{{ Auth::user()->name }}</h5>
                    <p class="text-muted small mb-3">{{ Auth::user()->email }}</p>
                    <hr>
                    <ul class="list-unstyled text-start mb-0">
                        <li class="mb-2"><a href="#" class="text-decoration-none text-primary fw-medium">My Blogs</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-dark">Write New Blog</a></li>
                        <li><a href="#" class="text-decoration-none text-dark">Profile Settings</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0">Dashboard Overview</h4>
                    <a href="#" class="btn btn-primary rounded-pill px-4">Write Blog</a>
                </div>
                
                <div class="alert alert-success rounded-3 border-0">
                    You are logged in! Welcome to your Tindablog dashboard.
                </div>

                <h5 class="fw-bold mt-5 mb-3">Your Recent Blogs</h5>
                <div class="text-center p-5 border rounded-4 text-muted bg-light">
                    You haven't written any blogs yet.
                    <br><br>
                    <a href="#" class="btn btn-outline-primary rounded-pill">Start Writing</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
HTML;
file_put_contents($dashboardViewFile, $dashboardContent);

echo "Dashboard route and view fixed.";
