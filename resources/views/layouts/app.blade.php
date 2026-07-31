<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', $settings['seo_description'] ?? 'Discover premium articles and exclusive content on Tindablog.')">
    <meta name="theme-color" content="#0f2a4a">
    <title>@yield('title', '{{ $settings["site_name"] ?? "Tindablog" }} - Premium Blogging')</title>
    <script>
        document.documentElement.setAttribute('data-bs-theme', 'light');
        // Prevent FOUC (Flash of Unstyled Content)
        document.documentElement.style.visibility = 'hidden';
        document.documentElement.style.opacity = '0';
        
        document.addEventListener('DOMContentLoaded', function() {
            document.documentElement.style.transition = 'opacity 0.3s ease, visibility 0.3s ease';
            document.documentElement.style.visibility = 'visible';
            document.documentElement.style.opacity = '1';
        });
    </script>
    <!-- Favicon -->
    @if(isset($settings['site_logo']) && !empty($settings['site_logo']))
        <link rel="icon" href="{{ $settings['site_logo'] }}">
    @endif
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
            --primary: #0f2a4a; /* Deep Navy from logo */
            --primary-light: #1e4a7d;
            --secondary: #c69c5e; /* Gold from logo */
            --dark: #071526;
            --light: #f8fafc;
            --gray: #64748b;
        }
        
        body { 
            font-family: 'Outfit', sans-serif; 
            background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
            min-height: 100vh;
            color: #1e293b; 
            overflow-x: hidden;
        }

        /* Advanced Navbar */
        .navbar { 
            background: rgba(255, 255, 255, 0.7); 
            backdrop-filter: blur(25px); 
            -webkit-backdrop-filter: blur(25px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05);
            padding: 15px 0;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .navbar.scrolled {
            padding: 10px 0;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 15px 35px -10px rgba(0, 0, 0, 0.1);
            transform: translateY(10px);
            border-radius: 50px;
            margin: 0 20px;
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
            color: #475569 !important;
            font-weight: 600;
            margin: 0 15px;
            position: relative;
            transition: all 0.3s ease;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }
        .nav-link:hover { color: var(--primary) !important; transform: translateY(-2px); }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 3px;
            bottom: -6px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 5px;
            opacity: 0;
        }
        .nav-link:hover::after { width: 100%; opacity: 1; }
        
        /* Advanced Buttons */
        .btn-primary { 
            background: linear-gradient(135deg, var(--primary), var(--secondary)); 
            border: none; 
            border-radius: 50px; 
            padding: 12px 30px; 
            font-weight: 600;
            box-shadow: 0 10px 20px -5px rgba(15, 42, 74, 0.4);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        .btn-primary::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, var(--secondary), var(--primary));
            z-index: -1; transition: opacity 0.4s ease; opacity: 0;
        }
        .btn-primary:hover {
            transform: translateY(-4px) scale(1.03);
            box-shadow: 0 15px 25px -5px rgba(198, 156, 94, 0.5);
        }
        .btn-primary:hover::before { opacity: 1; }
        
        .btn-outline-primary {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
            font-weight: 700;
            padding: 10px 28px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border-radius: 50px;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        .btn-outline-primary::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            z-index: -1; transition: opacity 0.4s ease; opacity: 0;
        }
        .btn-outline-primary:hover {
            border-color: transparent;
            color: white !important;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(15, 42, 74, 0.4);
        }
        .btn-outline-primary:hover::before { opacity: 1; }
        
        /* Advanced Search Bar */
        .advanced-search-input {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(241, 245, 249, 0.8) !important;
            border: 1px solid rgba(15, 42, 74, 0.1) !important;
        }
        .advanced-search-input:focus {
            background: #ffffff !important;
            box-shadow: 0 0 0 4px rgba(15, 42, 74, 0.1) !important;
            border-color: var(--primary) !important;
            padding-right: 50px;
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
            background: linear-gradient(135deg, #071526 0%, #0a1f3a 100%);
            color: #94a3b8; 
            padding: 100px 0 40px; 
            border-radius: 80px 80px 0 0; 
            margin-top: 100px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 -20px 50px rgba(0,0,0,0.1);
        }
        .footer::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 6px;
            background: linear-gradient(90deg, var(--primary), var(--secondary), #f59e0b, var(--primary));
            background-size: 300% 300%;
            animation: gradientMove 4s ease infinite;
        }
        .footer-glow {
            position: absolute;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(198,156,94,0.15) 0%, rgba(0,0,0,0) 70%);
            top: -100px; right: -100px;
            border-radius: 50%;
            z-index: 0;
            pointer-events: none;
        }
        .footer-glow-2 {
            position: absolute;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(15,42,74,0.4) 0%, rgba(0,0,0,0) 70%);
            bottom: -150px; left: -150px;
            border-radius: 50%;
            z-index: 0;
            pointer-events: none;
        }
        .footer-link {
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
            position: relative;
        }
        .footer-link:hover {
            color: white;
            transform: translateX(5px);
        }
        .footer-link::before {
            content: '\f105'; /* FontAwesome right angle */
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            left: -15px;
            opacity: 0;
            transition: all 0.3s ease;
            color: var(--secondary);
        }
        .footer-link:hover::before {
            opacity: 1;
            left: -20px;
        }
        .social-btn {
            width: 45px; height: 45px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-decoration: none;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        .social-btn::before {
            content: ''; position: absolute; top: 0; left: 0; w-100; h-100;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            z-index: -1; transition: opacity 0.4s ease; opacity: 0;
            width: 100%; height: 100%;
        }
        .social-btn:hover {
            transform: translateY(-5px) rotate(8deg);
            border-color: transparent;
            color: white;
        }
        .social-btn:hover::before { opacity: 1; }
        .subscribe-input {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: white;
            transition: all 0.3s ease;
        }
        .subscribe-input:focus {
            background: rgba(255,255,255,0.1);
            border-color: var(--secondary);
            box-shadow: 0 0 15px rgba(198,156,94,0.3);
            color: white;
        }
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        @keyframes dropdownFade {
            from { opacity: 0; transform: translateY(-15px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        
        /* Live Search Dropdown */
        #live-search-dropdown .dropdown-item {
            padding: 12px 15px;
            white-space: normal;
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.2s ease;
        }
        #live-search-dropdown .dropdown-item:last-child { border-bottom: none; }
        #live-search-dropdown .dropdown-item:hover { background-color: #f8fafc; padding-left: 20px; }
        #live-search-dropdown img {
            width: 45px; height: 45px; object-fit: cover; border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
            /* Dark Mode Overrides */
        [data-bs-theme="dark"] body {
            background: #0b1120 !important;
            color: #f1f5f9 !important;
        }
        [data-bs-theme="dark"] .navbar {
            background: rgba(15, 23, 42, 0.8) !important;
            border-bottom-color: rgba(255, 255, 255, 0.1) !important;
        }
        [data-bs-theme="dark"] .card, [data-bs-theme="dark"] .dash-sidebar, [data-bs-theme="dark"] .dash-table-card, [data-bs-theme="dark"] .settings-card, [data-bs-theme="dark"] .bg-white {
            background-color: #1e293b !important;
            border: 1px solid rgba(255,255,255,0.05) !important;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5) !important;
            color: #f1f5f9 !important;
        }
        [data-bs-theme="dark"] .text-dark { color: #f8fafc !important; }
        [data-bs-theme="dark"] .text-muted { color: #94a3b8 !important; }
        [data-bs-theme="dark"] .form-control { background-color: #0f172a; border-color: rgba(255,255,255,0.1); color: white; }
        [data-bs-theme="dark"] .form-control:focus { background-color: #0f172a; border-color: var(--secondary); color: white; }
        [data-bs-theme="dark"] .btn-light { background: #334155; border-color: #475569; color: white; }
        [data-bs-theme="dark"] .table-light { background: #334155; color: white; }
        [data-bs-theme="dark"] .table-custom thead th { background: #0f172a; border-bottom: 1px solid #334155; color: #94a3b8; }
        [data-bs-theme="dark"] .table-custom tbody td { border-bottom: 1px solid #334155; color: #f1f5f9; }
        [data-bs-theme="dark"] .table-custom tbody tr:hover { background: #1e293b; }
        [data-bs-theme="dark"] .nav-tabs .nav-link { color: #94a3b8; }
        [data-bs-theme="dark"] .nav-tabs .nav-link.active { color: white; border-bottom-color: var(--secondary); }
        [data-bs-theme="dark"] .news-card-small { border-bottom-color: rgba(255,255,255,0.1); }
        [data-bs-theme="dark"] .news-title-small { color: white; }
        [data-bs-theme="dark"] .dash-nav-link:hover, [data-bs-theme="dark"] .dash-nav-link.active { background: rgba(255,255,255,0.05); color: var(--secondary); border-left-color: var(--secondary); }
        
        /* Theme Toggle Button */
        .theme-toggle-btn {
            background: transparent; border: none; color: inherit;
            width: 40px; height: 40px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; transition: all 0.3s ease;
        }
        .theme-toggle-btn:hover { background: rgba(0,0,0,0.05); }
        [data-bs-theme="dark"] .theme-toggle-btn { color: #fbbf24; }
        [data-bs-theme="dark"] .theme-toggle-btn:hover { background: rgba(255,255,255,0.1); }
</style>
</head>
<body>
    <div id="nav-wrapper" style="position: fixed; top: 0; left: 0; width: 100%; z-index: 1030; transition: padding 0.4s ease;">
        <nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
        <div class="container-fluid px-4 px-xl-5">
            <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">
                @if(isset($settings["site_logo"]) && !empty($settings["site_logo"]))
                    <img src="{{ $settings["site_logo"] }}" alt="{{ $settings["site_name"] ?? "Logo" }}" width="150" height="65" style="max-height: 65px; width: auto; object-fit: contain; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                @else
                    <span>{{ $settings["site_name"] ?? "Tindablog" }}</span>
                @endif
            </a>
            <button class="navbar-toggler border-0 shadow-none d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNavOffcanvas" aria-controls="mobileNavOffcanvas">
                <i class="fa-solid fa-bars-staggered fs-3 text-dark"></i>
            </button>
            
            <!-- Desktop Navbar Content -->
            <div class="collapse navbar-collapse d-none d-lg-flex" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('public.categories') }}">Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="#latest">Latest News</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('page.show', $settings['header_about_slug'] ?? 'about') }}">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('page.show', $settings['header_contact_slug'] ?? 'contact') }}">Contact</a></li>
                </ul>
                <div class="d-flex align-items-center mt-3 mt-lg-0 gap-3">
                    <!-- Global Search -->
                    <form class="position-relative d-none d-xl-block" style="width: 280px;" onsubmit="return false;">
                        <input type="text" id="live-search-input" class="form-control rounded-pill pe-5 advanced-search-input" placeholder="Search articles..." style="padding: 12px 22px;" autocomplete="off">
                        <button type="button" aria-label="Search" class="btn position-absolute top-50 end-0 translate-middle-y text-primary border-0 shadow-none hover-scale" style="padding-right: 18px;"><i class="fa-solid fa-magnifying-glass fs-5"></i></button>
                        
                        <!-- Search Dropdown -->
                        <div id="live-search-dropdown" class="dropdown-menu shadow-lg border-0 w-100 mt-2" style="border-radius: 15px; display: none; position: absolute; max-height: 400px; overflow-y: auto; z-index: 1050; animation: dropdownFade 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);">
                            <!-- Results will be injected here -->
                        </div>
                    </form>

                    <!-- Write Blog CTA -->
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-primary rounded-pill d-none d-md-flex align-items-center" style="padding: 11px 24px;">
                            <i class="fa-solid fa-pen-nib me-2"></i> Write
                        </a>
                    @else
                        <a href="#" data-bs-toggle="modal" data-bs-target="#authModal" onclick="switchAuthTab('login')" class="btn btn-outline-primary rounded-pill d-none d-md-flex align-items-center" style="padding: 11px 24px;">
                            <i class="fa-solid fa-pen-nib me-2"></i> Write
                        </a>
                    @endauth

                    <div class="dropdown">
                        <button class="btn btn-primary rounded-circle shadow-sm d-flex align-items-center justify-content-center border-0 p-0" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false" style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--primary), var(--secondary)); box-shadow: 0 4px 15px rgba(15, 42, 74, 0.3) !important; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                            <i class="fa-solid fa-user fs-5 text-white"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userMenu" style="border-radius: 20px; margin-top: 18px; min-width: 250px; padding: 15px; animation: dropdownFade 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);">
                            @auth
                                <li class="px-3 py-2 text-muted border-bottom mb-2">
                                    <small class="text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">Signed in as</small><br>
                                    <strong class="text-dark fs-6">{{ auth()->user()->name }}</strong>
                                </li>
                                
                                <li><a class="dropdown-item fw-semibold py-2 rounded" href="{{ route('dashboard') }}"><i class="fa-solid fa-gauge text-primary me-2 w-20px"></i> Dashboard</a></li>
                                
                                <li><hr class="dropdown-divider my-2"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item fw-semibold py-2 text-danger rounded"><i class="fa-solid fa-right-from-bracket me-2 w-20px"></i> Logout</button>
                                    </form>
                                </li>
                            @else
                                <li class="px-3 py-2 text-muted border-bottom mb-2">
                                    <small class="text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">Welcome to {{ $settings["site_name"] ?? "Tindablog" }}</small>
                                </li>
                                <li><a class="dropdown-item fw-semibold py-2 rounded" href="#" data-bs-toggle="modal" data-bs-target="#authModal" onclick="switchAuthTab('login')"><i class="fa-solid fa-right-to-bracket text-primary me-2 w-20px"></i> Login</a></li>
                                <li><a class="dropdown-item fw-semibold py-2 rounded" href="#" data-bs-toggle="modal" data-bs-target="#authModal" onclick="switchAuthTab('register')"><i class="fa-solid fa-bolt text-primary me-2 w-20px"></i> Register</a></li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    </div>

    <!-- Mobile Offcanvas Menu (Outside Navbar to avoid z-index bugs) -->
    <div class="offcanvas offcanvas-end bg-white" tabindex="-1" id="mobileNavOffcanvas" aria-labelledby="mobileNavOffcanvasLabel">
        <div class="offcanvas-header border-bottom p-4">
            <h5 class="offcanvas-title fw-bold text-primary fs-4" id="mobileNavOffcanvasLabel">
                <i class="fa-solid fa-bolt text-warning me-2"></i> {{ $settings["site_name"] ?? "Tindablog" }}
            </h5>
            <button type="button" class="btn-close shadow-none fs-5" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-4 d-flex flex-column">
            <ul class="navbar-nav mb-4">
                <li class="nav-item mb-1"><a class="nav-link fs-6 fw-semibold" href="{{ url('/') }}"><i class="fa-solid fa-home text-muted me-3 w-20px"></i> Home</a></li>
                <li class="nav-item mb-1"><a class="nav-link fs-6 fw-semibold" href="{{ route('public.categories') }}"><i class="fa-solid fa-tags text-muted me-3 w-20px"></i> Categories</a></li>
                <li class="nav-item mb-1"><a class="nav-link fs-6 fw-semibold" href="#latest"><i class="fa-solid fa-newspaper text-muted me-3 w-20px"></i> Latest News</a></li>
                <li class="nav-item mb-1"><a class="nav-link fs-6 fw-semibold" href="{{ route('page.show', $settings['header_about_slug'] ?? 'about') }}"><i class="fa-solid fa-circle-info text-muted me-3 w-20px"></i> About Us</a></li>
                <li class="nav-item mb-1"><a class="nav-link fs-6 fw-semibold" href="{{ route('page.show', $settings['header_contact_slug'] ?? 'contact') }}"><i class="fa-solid fa-envelope text-muted me-3 w-20px"></i> Contact</a></li>
            </ul>
            
            <div class="mt-auto">
                <div class="bg-light p-4 rounded-4 text-center">
                    @auth
                        <div class="mb-3 text-start">
                            <small class="text-uppercase fw-bold text-muted" style="font-size: 0.7rem; letter-spacing: 1px;">Signed in as</small><br>
                            <strong class="text-dark fs-5">{{ auth()->user()->name }}</strong>
                        </div>
                        <a href="{{ route('dashboard') }}" class="btn btn-primary w-100 rounded-pill fw-bold py-2 mb-2"><i class="fa-solid fa-gauge me-2"></i> Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100 rounded-pill fw-bold py-2"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</button>
                        </form>
                    @else
                        <h5 class="fw-bold mb-3">Join our community!</h5>
                        <button type="button" data-bs-dismiss="offcanvas" data-bs-toggle="modal" data-bs-target="#authModal" onclick="switchAuthTab('login')" class="btn btn-primary w-100 rounded-pill fw-bold py-2 mb-3">Login</button>
                        <button type="button" data-bs-dismiss="offcanvas" data-bs-toggle="modal" data-bs-target="#authModal" onclick="switchAuthTab('register')" class="btn btn-outline-primary w-100 rounded-pill fw-bold py-2">Create Account</button>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    @yield('content')

    <footer class="footer">
        <div class="footer-glow"></div>
        <div class="footer-glow-2"></div>
        
        <div class="container position-relative z-index-2">
            <div class="row g-5 mb-5 pb-5 border-bottom border-light border-opacity-10">
                <!-- Column 1: Brand & About -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    @if(isset($settings["footer_logo"]) && !empty($settings["footer_logo"]))
                        <img src="{{ $settings["footer_logo"] }}" alt="{{ $settings["site_name"] ?? "Logo Footer" }}" width="150" height="80" loading="lazy" class="mb-4" style="max-height: 80px; width: auto; object-fit: contain; filter: drop-shadow(0 5px 15px rgba(0,0,0,0.3));">
                    @else
                        <h3 class="fw-bolder text-white mb-4" style="font-size: 2.5rem; letter-spacing: -1px; background: linear-gradient(135deg, #fff, #94a3b8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                            {{ $settings["site_name"] ?? "Tindablog" }}
                        </h3>
                    @endif
                    <p class="fs-6 opacity-75 mb-4 pe-lg-4" style="line-height: 1.8;">{{ $settings["footer_text"] ?? "A premium modern blogging platform designed to inspire. Dive into articles about technology, lifestyle, design, and business." }}</p>
                    <div class="d-flex gap-3">
                        <a href="{{ $settings['facebook'] ?? '#' }}" aria-label="Visit our Facebook page" class="social-btn"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="{{ $settings['twitter'] ?? '#' }}" aria-label="Visit our Twitter page" class="social-btn"><i class="fa-brands fa-twitter"></i></a>
                        <a href="{{ $settings['instagram'] ?? '#' }}" aria-label="Visit our Instagram page" class="social-btn"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" aria-label="Visit our LinkedIn page" class="social-btn"><i class="fa-brands fa-linkedin-in"></i></a>
                    </div>
                </div>

                <!-- Column 2: Quick Links -->
                <div class="col-lg-2 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <h5 class="fw-bold text-white mb-4">Quick Links</h5>
                    <ul class="list-unstyled d-flex flex-column gap-3 mb-0 ms-3">
                        <li><a href="{{ url('/') }}" class="footer-link">Home Page</a></li>
                        <li><a href="{{ route('public.categories') }}" class="footer-link">Categories</a></li>
                        <li><a href="#latest" class="footer-link">Latest News</a></li>
                        <li><a href="{{ route('page.show', $settings['header_about_slug'] ?? 'about') }}" class="footer-link">About Us</a></li>
                        <li><a href="{{ route('page.show', $settings['header_contact_slug'] ?? 'contact') }}" class="footer-link">Contact Support</a></li>
                    </ul>
                </div>

                <!-- Column 3: Legal & Auth -->
                <div class="col-lg-2 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <h5 class="fw-bold text-white mb-4">Account</h5>
                    <ul class="list-unstyled d-flex flex-column gap-3 mb-0 ms-3">
                        @auth
                            
                        @else
                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#authModal" onclick="switchAuthTab('login')" class="footer-link">Log In</a></li>
                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#authModal" onclick="switchAuthTab('register')" class="footer-link">Register</a></li>
                        @endauth
                        @php
                            $dynamicPages = \App\Models\Page::where('status', 'published')->get();
                        @endphp
                        @foreach($dynamicPages as $dynPage)
                            <li><a href="{{ route('page.show', $dynPage->slug) }}" class="footer-link">{{ $dynPage->title }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <!-- Column 4: Newsletter -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <h5 class="fw-bold text-white mb-4">Subscribe to Newsletter</h5>
                    <p class="opacity-75 mb-4">Get the latest articles and premium content delivered directly to your inbox. No spam, ever.</p>
                    
                    @if(session('success'))
                        <div class="alert alert-success py-2 mb-3 small border-0 bg-success text-white bg-opacity-75"><i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}</div>
                    @endif
                    @if($errors->has('email'))
                        <div class="alert alert-danger py-2 mb-3 small border-0 bg-danger text-white bg-opacity-75"><i class="fa-solid fa-circle-exclamation me-2"></i>{{ $errors->first('email') }}</div>
                    @endif

                    <form action="{{ route('subscribe') }}" method="POST" class="position-relative">
                        @csrf
                        <div class="input-group mb-3 p-1 rounded-pill" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                            <input type="email" name="email" class="form-control rounded-pill bg-transparent border-0 text-white shadow-none ps-4" placeholder="Your email address..." required style="color: white !important;">
                            <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" type="submit" style="margin: 2px;">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="mb-0 opacity-50 fw-medium">&copy; {{ date('Y') }} {{ $settings["site_name"] ?? "Tindablog" }}. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <!-- Global floating button now handles scroll to top -->
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Unified Auth Modal -->
    <div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header bg-light border-0 pb-0">
                    <ul class="nav nav-tabs border-0 w-100" id="authTab" role="tablist">
                        <li class="nav-item w-50 text-center" role="presentation">
                            <button class="nav-link active w-100 fw-bold border-0 bg-transparent text-primary" id="login-tab" data-bs-toggle="tab" data-bs-target="#loginPane" type="button" role="tab" style="font-size: 1.1rem; border-bottom: 3px solid var(--primary) !important;">Login</button>
                        </li>
                        <li class="nav-item w-50 text-center" role="presentation">
                            <button class="nav-link w-100 fw-bold border-0 bg-transparent text-secondary" id="register-tab" data-bs-toggle="tab" data-bs-target="#registerPane" type="button" role="tab" style="font-size: 1.1rem;">Register</button>
                        </li>
                    </ul>
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 p-md-5">
                    @if (session('status'))
                        <div class="alert alert-success p-2 mb-4 text-center fw-medium">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger p-2 mb-4">
                            <ul class="mb-0 text-sm">
                                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="tab-content" id="authTabContent">
                        
                        <!-- Login Form -->
                        <div class="tab-pane fade show active" id="loginPane" role="tabpanel">
                            <div id="loginAlert" class="alert d-none"></div>
                            <form id="loginForm" onsubmit="event.preventDefault();">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email Address</label>
                                    <input type="email" id="loginEmail" class="form-control rounded-pill px-4 py-2" required autofocus>
                                </div>
                                <div class="mb-4 d-none" id="loginOtpSection">
                                    <label class="form-label fw-bold">6-Digit OTP</label>
                                    <input type="text" id="loginOtp" class="form-control rounded-pill px-4 py-2" placeholder="Enter code sent to email" maxlength="6">
                                    <div id="loginTimer" class="text-danger small mt-2 fw-bold text-center"></div>
                                </div>
                                <button type="button" id="btnLoginSendOtp" class="btn btn-primary w-100 rounded-pill py-2 fw-bold fs-5 mb-3" onclick="sendOtp('login')">Send OTP</button>
                                <button type="button" id="btnLoginVerifyOtp" class="btn btn-success w-100 rounded-pill py-2 fw-bold fs-5 mb-3 d-none" onclick="verifyOtp('login')">Verify & Sign In</button>
                                
                                <div class="text-center mt-3">
                                    <span class="text-muted">Don't have an account?</span> 
                                    <a href="#" class="text-primary fw-bold text-decoration-none" onclick="switchAuthTab('register')">Create one now</a>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Register Form -->
                        <div class="tab-pane fade" id="registerPane" role="tabpanel">
                            <div id="registerAlert" class="alert d-none"></div>
                            <form id="registerForm" onsubmit="event.preventDefault();">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Full Name</label>
                                    <input type="text" id="registerName" class="form-control rounded-pill px-4 py-2" required autofocus>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email Address</label>
                                    <input type="email" id="registerEmail" class="form-control rounded-pill px-4 py-2" required>
                                </div>
                                <div class="mb-4 d-none" id="registerOtpSection">
                                    <label class="form-label fw-bold">6-Digit OTP</label>
                                    <input type="text" id="registerOtp" class="form-control rounded-pill px-4 py-2" placeholder="Enter code sent to email" maxlength="6">
                                    <div id="registerTimer" class="text-danger small mt-2 fw-bold text-center"></div>
                                </div>
                                <button type="button" id="btnRegisterSendOtp" class="btn btn-primary w-100 rounded-pill py-2 fw-bold fs-5 mb-3" onclick="sendOtp('register')">Send OTP</button>
                                <button type="button" id="btnRegisterVerifyOtp" class="btn btn-success w-100 rounded-pill py-2 fw-bold fs-5 mb-3 d-none" onclick="verifyOtp('register')">Verify & Create Account</button>
                                
                                <div class="text-center mt-3">
                                    <span class="text-muted">Already registered?</span> 
                                    <a href="#" class="text-primary fw-bold text-decoration-none" onclick="switchAuthTab('login')">Log in here</a>
                                </div>
                            </form>
                        </div>
                        
                        <script>
                            function showAlert(type, message, isError = false) {
                                const alertBox = document.getElementById(type + 'Alert');
                                alertBox.className = 'alert ' + (isError ? 'alert-danger' : 'alert-success');
                                alertBox.innerText = message;
                                alertBox.classList.remove('d-none');
                            }

                            function sendOtp(type) {
                                const email = document.getElementById(type + 'Email').value;
                                const name = type === 'register' ? document.getElementById('registerName').value : null;
                                const btn = document.getElementById('btn' + (type === 'login' ? 'Login' : 'Register') + 'SendOtp');
                                
                                if (!email) return showAlert(type, 'Please enter your email.', true);
                                if (type === 'register' && !name) return showAlert(type, 'Please enter your name.', true);

                                btn.disabled = true;
                                btn.innerText = 'Sending...';

                                const url = type === 'login' ? '{{ route("otp.login.send") }}' : '{{ route("otp.register.send") }}';
                                
                                fetch(url, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({ email: email, name: name })
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        showAlert(type, data.message);
                                        document.getElementById(type + 'OtpSection').classList.remove('d-none');
                                        btn.classList.add('d-none');
                                        document.getElementById('btn' + (type === 'login' ? 'Login' : 'Register') + 'VerifyOtp').classList.remove('d-none');
                                        document.getElementById(type + 'Email').readOnly = true;
                                        if (type === 'register') document.getElementById('registerName').readOnly = true;
                                        
                                        // Start Timer
                                        let timeLeft = 60;
                                        const timerEl = document.getElementById(type + 'Timer');
                                        timerEl.innerText = `Expires in 01:00`;
                                        const timerId = setInterval(() => {
                                            timeLeft--;
                                            let seconds = timeLeft < 10 ? '0' + timeLeft : timeLeft;
                                            timerEl.innerText = `Expires in 00:${seconds}`;
                                            if (timeLeft <= 0) {
                                                clearInterval(timerId);
                                                timerEl.innerText = 'OTP Expired! Please refresh and try again.';
                                                document.getElementById('btn' + (type === 'login' ? 'Login' : 'Register') + 'VerifyOtp').disabled = true;
                                            }
                                        }, 1000);
                                    } else {
                                        showAlert(type, data.message || 'Error occurred.', true);
                                        btn.disabled = false;
                                        btn.innerText = 'Send OTP';
                                    }
                                })
                                .catch(err => {
                                    showAlert(type, 'Network error. Try again.', true);
                                    btn.disabled = false;
                                    btn.innerText = 'Send OTP';
                                });
                            }

                            function verifyOtp(type) {
                                const email = document.getElementById(type + 'Email').value;
                                const otp = document.getElementById(type + 'Otp').value;
                                const btn = document.getElementById('btn' + (type === 'login' ? 'Login' : 'Register') + 'VerifyOtp');

                                if (!otp) return showAlert(type, 'Please enter the OTP.', true);

                                btn.disabled = true;
                                btn.innerText = 'Verifying...';

                                fetch('{{ route("otp.verify") }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({ email: email, otp: otp })
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        showAlert(type, data.message);
                                        window.location.href = data.redirect;
                                    } else {
                                        showAlert(type, data.message, true);
                                        btn.disabled = false;
                                        btn.innerText = type === 'login' ? 'Verify & Sign In' : 'Verify & Create Account';
                                    }
                                })
                                .catch(err => {
                                    showAlert(type, 'Network error. Try again.', true);
                                    btn.disabled = false;
                                    btn.innerText = type === 'login' ? 'Verify & Sign In' : 'Verify & Create Account';
                                });
                            }
                        </script>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Global Back to Top Button -->
    <button aria-label="Scroll back to top" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" id="backToTopBtn" class="btn btn-primary rounded-circle shadow-lg d-flex align-items-center justify-content-center" style="position: fixed; bottom: 30px; right: 30px; width: 50px !important; height: 50px !important; padding: 0 !important; z-index: 1040; opacity: 0; visibility: hidden; transition: all 0.3s ease; border: 2px solid rgba(255,255,255,0.2);">
        <i class="fa-solid fa-arrow-up fs-5"></i>
    </button>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });
        
        // Navbar and Back to top effect on scroll
        window.addEventListener('scroll', function() {
            // Navbar
            if (window.scrollY > 50) {
                document.getElementById('nav-wrapper').style.paddingTop = '15px';
                document.getElementById('mainNav').classList.add('scrolled');
            } else {
                document.getElementById('nav-wrapper').style.paddingTop = '0px';
                document.getElementById('mainNav').classList.remove('scrolled');
            }
            
            // Back to top button
            const backBtn = document.getElementById('backToTopBtn');
            if (window.scrollY > 300) {
                backBtn.style.opacity = '1';
                backBtn.style.visibility = 'visible';
                backBtn.style.transform = 'translateY(0)';
            } else {
                backBtn.style.opacity = '0';
                backBtn.style.visibility = 'hidden';
                backBtn.style.transform = 'translateY(20px)';
            }
        });
        // Auth Modal Tab Switcher and Error Handling
        function switchAuthTab(tab) {
            const loginTab = document.getElementById('login-tab');
            const registerTab = document.getElementById('register-tab');
            
            if (tab === 'login') {
                var bsTab = new bootstrap.Tab(loginTab);
                bsTab.show();
                loginTab.style.borderBottom = '3px solid var(--primary)';
                loginTab.classList.replace('text-secondary', 'text-primary');
                registerTab.style.borderBottom = 'none';
                registerTab.classList.replace('text-primary', 'text-secondary');
            } else {
                var bsTab = new bootstrap.Tab(registerTab);
                bsTab.show();
                registerTab.style.borderBottom = '3px solid var(--primary)';
                registerTab.classList.replace('text-secondary', 'text-primary');
                loginTab.style.borderBottom = 'none';
                loginTab.classList.replace('text-primary', 'text-secondary');
            }
        }

        // Reopen modal if there are validation errors or session status
        @if($errors->any() || session('status'))
            document.addEventListener("DOMContentLoaded", function() {
                var authModal = new bootstrap.Modal(document.getElementById('authModal'));
                authModal.show();
                // Check if it's a registration error (usually has a 'name' field error or password mismatch)
                @if($errors->has('name') || $errors->has('password_confirmation'))
                    switchAuthTab('register');
                @endif
            });
        @endif

        // Live Search AJAX
        const searchInput = document.getElementById('live-search-input');
        const searchDropdown = document.getElementById('live-search-dropdown');
        let searchTimeout = null;

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                clearTimeout(searchTimeout);
                
                if (query.length < 2) {
                    searchDropdown.style.display = 'none';
                    return;
                }
                
                // Show loading state
                searchDropdown.innerHTML = '<div class="px-3 py-3 text-center text-primary"><i class="fa-solid fa-circle-notch fa-spin fs-4"></i></div>';
                searchDropdown.style.display = 'block';
                
                searchTimeout = setTimeout(() => {
                    fetch(`/api/search?q=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            searchDropdown.innerHTML = '';
                            if (data.length === 0) {
                                searchDropdown.innerHTML = '<div class="px-4 py-3 text-muted small text-center"><i class="fa-solid fa-magnifying-glass mb-2 fs-4 opacity-50"></i><br>No articles found</div>';
                            } else {
                                data.forEach(blog => {
                                    searchDropdown.innerHTML += `
                                        <a href="${blog.url}" class="dropdown-item d-flex align-items-center gap-3 text-decoration-none">
                                            <img src="${blog.image_url}" alt="${blog.title}" loading="lazy" width="40" height="40" style="object-fit: cover; border-radius: 6px;">
                                            <div class="overflow-hidden">
                                                <div class="fw-bold text-dark text-truncate mb-1" style="font-size: 0.9rem;">${blog.title}</div>
                                                <div class="text-muted" style="font-size: 0.75rem;"><i class="fa-regular fa-calendar me-1"></i> ${blog.date}</div>
                                            </div>
                                        </a>
                                    `;
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Search error:', error);
                            searchDropdown.innerHTML = '<div class="px-3 py-2 text-danger small text-center">Error loading results</div>';
                        });
                }, 400); // 400ms debounce delay
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !searchDropdown.contains(e.target)) {
                    searchDropdown.style.display = 'none';
                }
            });
            
            searchInput.addEventListener('focus', function() {
                if (this.value.trim().length >= 2 && searchDropdown.innerHTML.trim() !== '') {
                    searchDropdown.style.display = 'block';
                }
            });
        }
    </script>
    <!-- Theme Toggle Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const themeToggleBtn = document.getElementById('themeToggle');
            if(!themeToggleBtn) return;
            const darkIcon = themeToggleBtn.querySelector('.dark-icon');
            const lightIcon = themeToggleBtn.querySelector('.light-icon');
            
            function updateIcons(theme) {
                if (theme === 'dark') {
                    darkIcon.classList.add('d-none');
                    lightIcon.classList.remove('d-none');
                } else {
                    lightIcon.classList.add('d-none');
                    darkIcon.classList.remove('d-none');
                }
            }
            
            const currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';
            updateIcons(currentTheme);
            
            themeToggleBtn.addEventListener('click', () => {
                let theme = document.documentElement.getAttribute('data-bs-theme') || 'light';
                let newTheme = theme === 'dark' ? 'light' : 'dark';
                
                document.documentElement.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                updateIcons(newTheme);
            });
        });
    </script>
    
</body>
</html>