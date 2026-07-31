<?php
$dir = __DIR__;

// 1. Update app.blade.php to include AOS and advanced global CSS
$appLayout = $dir . '/resources/views/layouts/app.blade.php';
$appHtml = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '{{ \$settings["site_name"] ?? "Tindablog" }} - Premium Blogging')</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #818cf8;
            --secondary: #ec4899;
            --dark: #0f172a;
            --light: #f8fafc;
            --gray: #64748b;
        }
        
        body { 
            font-family: 'Outfit', sans-serif; 
            background-color: #f1f5f9; 
            color: #1e293b; 
            overflow-x: hidden;
        }

        /* Advanced Navbar */
        .navbar { 
            background: rgba(255, 255, 255, 0.65); 
            backdrop-filter: blur(20px); 
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.08);
            padding: 15px 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .navbar.scrolled {
            padding: 10px 0;
            background: rgba(255, 255, 255, 0.85);
        }
        .navbar-brand span {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            font-size: 1.8rem;
            letter-spacing: -0.5px;
        }
        .nav-link {
            color: var(--gray) !important;
            font-weight: 600;
            margin: 0 12px;
            position: relative;
            transition: color 0.3s ease;
        }
        .nav-link:hover { color: var(--primary) !important; }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 3px;
            bottom: -5px;
            left: 0;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transition: width 0.3s ease;
            border-radius: 5px;
        }
        .nav-link:hover::after { width: 100%; }
        
        /* Advanced Buttons */
        .btn-primary { 
            background: linear-gradient(135deg, var(--primary), var(--secondary)); 
            border: none; 
            border-radius: 50px; 
            padding: 12px 30px; 
            font-weight: 600;
            box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.5);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-primary:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 15px 25px -5px rgba(79, 70, 229, 0.6);
        }
        .btn-outline-primary {
            border: 2px solid var(--primary);
            color: var(--primary);
            font-weight: 600;
            padding: 10px 28px;
            transition: all 0.3s ease;
            border-radius: 50px;
        }
        .btn-outline-primary:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);
        }

        /* Modern Blog Cards */
        .blog-card { 
            background: white; 
            border-radius: 24px; 
            border: 1px solid rgba(255,255,255,0.8); 
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.05); 
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            position: relative;
        }
        .blog-card:hover { 
            transform: translateY(-10px); 
            box-shadow: 0 30px 50px -15px rgba(0, 0, 0, 0.12); 
        }
        .blog-card .card-img-wrapper {
            overflow: hidden;
            border-radius: 24px 24px 0 0;
            position: relative;
        }
        .blog-card .card-img-top {
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .blog-card:hover .card-img-top {
            transform: scale(1.08);
        }
        
        /* Advanced Footer */
        .footer { 
            background: var(--dark); 
            color: #94a3b8; 
            padding: 80px 0 40px; 
            border-radius: 60px 60px 0 0; 
            margin-top: 80px;
            position: relative;
            overflow: hidden;
        }
        .footer::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--secondary), var(--primary));
            background-size: 200% 200%;
            animation: gradientMove 3s ease infinite;
        }
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="/">
                @if(isset(\$settings["site_logo"]) && !empty(\$settings["site_logo"]))
                    <img src="{{ \$settings["site_logo"] }}" alt="{{ \$settings["site_name"] ?? "Logo" }}" style="max-height: 60px; object-fit: contain; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                @else
                    <span>{{ \$settings["site_name"] ?? "Tindablog" }}</span>
                @endif
            </a>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fa-solid fa-bars-staggered fs-3 text-dark"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('public.categories') }}">Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="#latest">Latest News</a></li>
                </ul>
                <div class="d-flex align-items-center mt-3 mt-lg-0">
                    @auth
                        <div class="dropdown">
                            <button class="btn btn-primary rounded-circle shadow-sm d-flex align-items-center justify-content-center" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false" style="width: 48px; height: 48px; padding: 0;">
                                <i class="fa-solid fa-user fs-5"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" aria-labelledby="userMenu" style="border-radius: 16px; margin-top: 15px; min-width: 220px; padding: 10px;">
                                <li class="px-3 py-2 text-muted border-bottom mb-2">
                                    <small class="text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">Signed in as</small><br>
                                    <strong class="text-dark fs-6">{{ auth()->user()->name }}</strong>
                                </li>
                                
                                @if(auth()->user()->is_admin)
                                    <li><a class="dropdown-item fw-semibold py-2 rounded" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-shield-halved text-primary me-2 w-20px"></i> Admin Panel</a></li>
                                @else
                                    <li><a class="dropdown-item fw-semibold py-2 rounded" href="{{ route('dashboard') }}"><i class="fa-solid fa-gauge text-primary me-2 w-20px"></i> Dashboard</a></li>
                                @endif
                                
                                <li><hr class="dropdown-divider my-2"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item fw-semibold py-2 text-danger rounded"><i class="fa-solid fa-right-from-bracket me-2 w-20px"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary me-2"><i class="fa-solid fa-right-to-bracket me-2"></i> Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary"><i class="fa-solid fa-bolt me-2"></i> Get Started</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="footer">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6 text-center text-lg-start" data-aos="fade-right">
                    <h3 class="fw-bold text-white mb-3" style="font-size: 2.5rem; letter-spacing: -1px;">{{ \$settings["site_name"] ?? "Tindablog" }}</h3>
                    <p class="fs-5 opacity-75 mb-0" style="max-width: 400px;">{{ \$settings["footer_text"] ?? "A premium modern blogging platform designed to inspire." }}</p>
                </div>
                <div class="col-lg-6 text-center text-lg-end" data-aos="fade-left">
                    <div class="d-inline-flex gap-3 mb-4">
                        <a href="#" class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;"><i class="fa-brands fa-github"></i></a>
                        <a href="#" class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;"><i class="fa-brands fa-linkedin"></i></a>
                    </div>
                    <p class="mb-0 opacity-50">&copy; {{ date('Y') }} {{ \$settings["site_name"] ?? "Tindablog" }}. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });
        
        // Navbar shrink effect on scroll
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                document.getElementById('mainNav').classList.add('scrolled');
            } else {
                document.getElementById('mainNav').classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
HTML;
file_put_contents($appLayout, $appHtml);


// 2. Update welcome.blade.php for an Advanced Homepage layout
$welcomeView = $dir . '/resources/views/welcome.blade.php';
$welcomeHtml = <<<HTML
@extends('layouts.app')

@section('title', \$settings['site_name'] . ' - Home')

@section('content')

<!-- Advanced Hero Section -->
<section class="hero position-relative overflow-hidden d-flex align-items-center" style="min-height: 85vh; background: #0f172a;">
    <!-- Background Image with Overlay -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ \$settings['hero_image'] ?? 'https://images.unsplash.com/photo-1499750310107-5fef28a66643' }}'); background-size: cover; background-position: center; filter: blur(3px) brightness(0.4); transform: scale(1.05);"></div>
    
    <!-- Gradient Overlay -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.8) 0%, rgba(15, 23, 42, 0.9) 100%); mix-blend-mode: multiply;"></div>

    <div class="container position-relative z-index-2 text-white text-center pt-5 mt-5">
        <div data-aos="zoom-out-up" data-aos-duration="1000">
            <span class="badge bg-white text-primary rounded-pill px-4 py-2 fw-bold mb-4 shadow-lg text-uppercase" style="letter-spacing: 2px; font-size: 0.85rem;"><i class="fa-solid fa-fire text-danger me-2"></i> Join the Revolution</span>
            <h1 class="display-2 fw-bolder mb-4 lh-sm" style="letter-spacing: -2px;">
                {{ \$settings['hero_title'] ?? 'Welcome to Tindablog' }}
            </h1>
            <p class="lead mb-5 mx-auto" style="max-width: 700px; font-size: 1.25rem; font-weight: 300; opacity: 0.9;">
                {{ \$settings['hero_subtitle'] ?? 'Discover premium articles on technology, lifestyle, and business curated just for you.' }}
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="#latest" class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-primary shadow-lg" style="transition: all 0.3s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">Explore Articles</a>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg rounded-pill px-5 fw-bold" style="border-width: 2px; transition: all 0.3s;" onmouseover="this.style.background='white'; this.style.color='#0f172a';" onmouseout="this.style.background='transparent'; this.style.color='white';">Join Now</a>
                @endguest
            </div>
        </div>
    </div>
    
    <!-- Wave Shape Divider -->
    <div class="position-absolute bottom-0 start-0 w-100" style="height: 100px; overflow: hidden; line-height: 0;">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="width: 100%; height: 100px; display: block;">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C59.71,118.06,155.43,118.06,233.15,103.88Z" fill="#f1f5f9"></path>
        </svg>
    </div>
</section>

<!-- Modern Explore Topics Section -->
@if(isset(\$categories) && count(\$categories) > 0 && !isset(\$category))
<div class="container position-relative" style="margin-top: -30px; z-index: 10;" data-aos="fade-up" data-aos-delay="200">
    <div class="card border-0 shadow-lg" style="border-radius: 20px; background: rgba(255,255,255,0.9); backdrop-filter: blur(10px);">
        <div class="card-body p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bolder m-0 text-dark"><i class="fa-solid fa-compass text-primary me-2"></i> Explore Topics</h4>
                <a href="{{ route('public.categories') }}" class="text-decoration-none fw-bold" style="color: var(--primary);">View All <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>
            <div class="d-flex overflow-auto pb-2 gap-3" style="scrollbar-width: none;">
                <style> .overflow-auto::-webkit-scrollbar { display: none; } </style>
                @foreach(\$categories as \$cat)
                    <a href="{{ route('blog.category', \$cat->slug) }}" class="btn btn-outline-dark rounded-pill px-4 py-2 fw-semibold" style="white-space: nowrap; transition: all 0.3s; border-color: #e2e8f0;" onmouseover="this.style.background='var(--primary)'; this.style.color='white'; this.style.borderColor='var(--primary)'; this.style.transform='translateY(-3px)';" onmouseout="this.style.background='transparent'; this.style.color='#1e293b'; this.style.borderColor='#e2e8f0'; this.style.transform='translateY(0)';">
                        {{ \$cat->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

<!-- Advanced Blog Grid -->
<div id="latest" class="container" style="padding-top: 100px; padding-bottom: 80px;">
    <div class="text-center mb-5" data-aos="fade-up">
        <h2 class="display-5 fw-bolder mb-3" style="letter-spacing: -1px; color: var(--dark);">{{ isset(\$category) ? "Browsing: " . \$category->name : "Latest Articles" }}</h2>
        <div class="mx-auto" style="width: 80px; height: 5px; background: linear-gradient(90deg, var(--primary), var(--secondary)); border-radius: 10px;"></div>
    </div>

    <div class="row g-5">
        @forelse(\$blogs as \$index => \$blog)
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ (\$index % 3) * 150 }}">
            <div class="card blog-card h-100">
                <div class="card-img-wrapper" style="height: 240px;">
                    <a href="{{ route('blog.show', \$blog->slug) }}" class="d-block h-100">
                        <img src="{{ \$blog->featured_image }}" class="card-img-top h-100 w-100" alt="{{ \$blog->title }}" style="object-fit: cover;">
                    </a>
                    <a href="{{ route('blog.category', \$blog->category->slug ?? 'uncategorized') }}" class="position-absolute top-0 start-0 m-3 text-decoration-none" style="z-index: 10;">
                        <span class="badge" style="background: rgba(255,255,255,0.9); color: var(--primary); backdrop-filter: blur(5px); font-size: 0.8rem; padding: 8px 15px; border-radius: 30px; font-weight: 700; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                            {{ \$blog->category->name ?? 'News' }}
                        </span>
                    </a>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex align-items-center mb-3 text-muted small fw-medium">
                        <span class="me-3"><i class="fa-regular fa-calendar me-1 text-primary"></i> {{ \$blog->created_at->format('M d, Y') }}</span>
                        <span><i class="fa-regular fa-eye me-1 text-primary"></i> {{ \$blog->views ?? 0 }} Views</span>
                    </div>
                    <a href="{{ route('blog.show', \$blog->slug) }}" class="text-decoration-none">
                        <h4 class="card-title fw-bold mb-3 text-dark lh-sm" style="transition: color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='#1e293b'">{{ \$blog->title }}</h4>
                    </a>
                    <p class="card-text text-muted mb-4" style="line-height: 1.7; flex-grow: 1;">{{ Str::limit(\$blog->excerpt, 120) }}</p>
                    
                    <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center fw-bold me-2" style="width: 35px; height: 35px; font-size: 0.9rem;">
                                {{ substr(\$blog->user->name ?? 'A', 0, 1) }}
                            </div>
                            <span class="fw-semibold text-dark small">{{ \$blog->user->name ?? 'Admin' }}</span>
                        </div>
                        <a href="{{ route('blog.show', \$blog->slug) }}" class="btn btn-sm btn-light rounded-circle text-primary shadow-sm" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; transition: all 0.3s;" onmouseover="this.style.background='var(--primary)'; this.style.color='white';" onmouseout="this.style.background='#f8f9fa'; this.style.color='var(--primary)';">
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                    
                    <!-- Stretched link for entire card accessibility -->
                    <a href="{{ route('blog.show', \$blog->slug) }}" class="stretched-link" style="opacity: 0;">Read More</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="p-5 bg-white rounded-4 shadow-sm">
                <i class="fa-regular fa-folder-open display-1 text-muted mb-3 opacity-25"></i>
                <h3 class="fw-bold text-dark">No Articles Found</h3>
                <p class="text-muted">Check back later for exciting new content!</p>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
HTML;
file_put_contents($welcomeView, $welcomeHtml);

echo "Advanced Premium UI Implemented Successfully.";
