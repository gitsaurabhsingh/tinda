
@extends('layouts.app')

@section('title', $settings['site_name'] . (isset($category) ? ' - ' . $category->name : ' - Home'))

@section('content')

<!-- Advanced 3D Hero Section -->
<style>
    .hero-3d {
        perspective: 1000px;
        transform-style: preserve-3d;
    }
    
    .floating-shape {
        position: absolute;
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 25px 45px rgba(0,0,0,0.1);
        border-radius: 20px;
        animation: float3D 10s infinite linear;
        z-index: 1;
    }
    
    .shape-1 { width: 120px; height: 120px; top: 15%; left: 10%; animation-duration: 12s; }
    .shape-2 { width: 180px; height: 180px; top: 50%; right: 5%; animation-duration: 15s; animation-direction: reverse; border-radius: 50%; }
    .shape-3 { width: 80px; height: 80px; bottom: 20%; left: 20%; animation-duration: 9s; border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
    
    @keyframes float3D {
        0% { transform: translateY(0) rotateX(0deg) rotateY(0deg) rotateZ(0deg); }
        33% { transform: translateY(-30px) rotateX(20deg) rotateY(40deg) rotateZ(15deg); }
        66% { transform: translateY(20px) rotateX(-20deg) rotateY(-20deg) rotateZ(-15deg); }
        100% { transform: translateY(0) rotateX(0deg) rotateY(0deg) rotateZ(0deg); }
    }

    .hero-content {
        transform: translateZ(50px);
        transition: transform 0.3s ease;
    }
    
    .btn-3d {
        transform-style: preserve-3d;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .btn-3d:hover {
        transform: translateY(-5px) translateZ(20px) scale(1.05);
        box-shadow: 0 15px 35px rgba(0,0,0,0.2), 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .bg-overlay {
        animation: breathing 8s infinite alternate;
    }
    
    @keyframes breathing {
        0% { filter: brightness(0.8) contrast(1.0); }
        100% { filter: brightness(0.9) contrast(1.1); }
    }
</style>

<section class="hero position-relative overflow-hidden d-flex align-items-center hero-3d" style="min-height: 85vh; background: #070b14;">
    <!-- Animated 3D Shapes -->
    <div class="floating-shape shape-1 d-none d-md-block"></div>
    <div class="floating-shape shape-2 d-none d-md-block"></div>
    <div class="floating-shape shape-3 d-none d-md-block"></div>

    <!-- Background Image with Animated Overlay -->
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-overlay" style="background-image: url('{{ $settings['hero_image'] ?? 'https://images.unsplash.com/photo-1499750310107-5fef28a66643' }}'); background-size: cover; background-position: center;"></div>
    
    <!-- Light Gradient Overlay for Text Readability -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.1) 100%);"></div>

    <div class="container position-relative z-index-2 text-white text-center pt-5 pb-5 mt-5 mb-4 hero-content">
        <div data-aos="zoom-out-up" data-aos-duration="1200">
            <h1 class="display-2 fw-bolder mb-4 lh-sm" style="letter-spacing: -2px; text-shadow: 0 10px 30px rgba(0,0,0,0.5);">
                {{ $settings['hero_title'] ?? 'Welcome to Tindablog' }}
            </h1>
            <p class="lead mb-5 mx-auto" style="max-width: 700px; font-size: 1.25rem; font-weight: 300; text-shadow: 0 5px 15px rgba(0,0,0,0.3);">
                {{ $settings['hero_subtitle'] ?? 'Discover premium articles on technology, lifestyle, and business curated just for you.' }}
            </p>
            <div class="d-flex justify-content-center gap-4">
                <a href="#latest" class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-primary btn-3d">Explore Articles</a>
                @guest
                    <a href="#" data-bs-toggle="modal" data-bs-target="#authModal" onclick="switchAuthTab('register')" class="btn btn-outline-light btn-lg rounded-pill px-5 fw-bold btn-3d" style="border-width: 2px;">Join Now</a>
                @endguest
            </div>
        </div>
    </div>
    
    <!-- Animated SVG Wave Divider -->
    <div class="position-absolute bottom-0 start-0 w-100" style="height: 100px; overflow: hidden; line-height: 0;">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="width: 100%; height: 100px; display: block; transform: rotate(180deg);">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="#f1f5f9"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="#f1f5f9"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="#f1f5f9"></path>
        </svg>
    </div>
</section>

<!-- Categories Marquee Section -->
@if(isset($categories) && count($categories) > 0)
<div class="container-fluid px-4 px-xl-5 position-relative" style="margin-top: 10px; z-index: 10;" data-aos="fade-up" data-aos-delay="200">
    <div class="card border-0 shadow-lg" style="border-radius: 20px; background: rgba(255,255,255,0.9); backdrop-filter: blur(10px);">
        <div class="card-body p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bolder m-0 text-dark"><i class="fa-solid fa-layer-group text-primary me-2"></i> Categories</h4>
                
            </div>
            
            <div class="marquee-wrapper" style="overflow: hidden; white-space: nowrap; position: relative; width: 100%; padding-bottom: 15px;">
                <style>
                    .marquee-content {
                        display: inline-flex;
                        animation: smooth-marquee 35s linear infinite;
                    }
                    .marquee-content:hover {
                        animation-play-state: paused;
                    }
                    @keyframes smooth-marquee {
                        0% { transform: translateX(0); }
                        100% { transform: translateX(-50%); }
                    }
                    
                    .mini-category-card {
                        width: 250px;
                        margin-right: 25px;
                        white-space: normal;
                        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
                        flex-shrink: 0;
                    }
                    .mini-category-card:hover {
                        transform: translateY(-10px);
                    }
                    .mini-category-card:hover .mini-category-img {
                        transform: scale(1.08);
                    }
                    .mini-category-card:hover .card-title {
                        color: var(--primary) !important;
                    }
                </style>
                
                <div class="marquee-content">
                    <!-- First Set -->
                    @foreach($categories as $category)
                    <div class="mini-category-card">
                        <a href="{{ route('blog.category', $category->slug) }}" class="text-decoration-none">
                            <div class="card border-0 rounded-4 shadow-sm h-100 overflow-hidden bg-white" style="border: 1px solid rgba(0,0,0,0.05) !important;">
                                <div class="position-relative overflow-hidden" style="height: 160px;">
                                    <img src="{{ $category->image ? asset($category->image) : 'https://placehold.co/400x300/e2e8f0/475569?text='.$category->name }}" alt="{{ $category->name }}" loading="lazy" width="250" height="160" class="img-fluid w-100 h-100 mini-category-img" style="object-fit: cover; transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);">
                                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(0,0,0,0.4);">
                                        <h5 class="fw-bold text-white m-0 text-center text-uppercase" style="letter-spacing: 1px; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">{{ $category->name }}</h5>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                    
                    <!-- Duplicated Set for Seamless Looping -->
                    @foreach($categories as $category)
                    <div class="mini-category-card">
                        <a href="{{ route('blog.category', $category->slug) }}" class="text-decoration-none">
                            <div class="card border-0 rounded-4 shadow-sm h-100 overflow-hidden bg-white" style="border: 1px solid rgba(0,0,0,0.05) !important;">
                                <div class="position-relative overflow-hidden" style="height: 160px;">
                                    <img src="{{ $category->image ? asset($category->image) : 'https://placehold.co/400x300/e2e8f0/475569?text='.$category->name }}" alt="{{ $category->name }}" loading="lazy" width="250" height="160" class="img-fluid w-100 h-100 mini-category-img" style="object-fit: cover; transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);">
                                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(0,0,0,0.4);">
                                        <h5 class="fw-bold text-white m-0 text-center text-uppercase" style="letter-spacing: 1px; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">{{ $category->name }}</h5>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<!-- Magazine Style 3-Column Layout -->
<div id="latest" class="container-fluid px-4 px-xl-5 bg-white rounded-4 shadow-sm" style="margin-top: 50px; margin-bottom: 80px; padding: 30px;">
    
    <style>
        .news-card-small {
            transition: transform 0.2s;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        .news-card-small:last-child {
            border-bottom: none;
            padding-bottom: 0;
            margin-bottom: 0;
        }
        .news-card-small:hover {
            transform: translateX(5px);
        }
        .news-img-small {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }
        .news-title-small {
            font-size: 0.95rem;
            font-weight: 700;
            line-height: 1.3;
            color: #1e293b;
            text-decoration: none;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .news-title-small:hover {
            color: var(--primary);
        }
        .news-meta-small {
            font-size: 0.75rem;
            color: #64748b;
            margin-top: 5px;
        }
        
        /* Section Header Styles */
        .section-header {
            border-bottom: 2px solid #e2e8f0;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .section-header h3 {
            font-size: 1.1rem;
            font-weight: 800;
            text-transform: uppercase;
            margin: 0;
            padding-bottom: 10px;
            border-bottom: 3px solid var(--primary);
            margin-bottom: -2px; /* Pull down to overlap gray border */
        }
        
        /* Nav Tabs specific to left column */
        .left-tabs .nav-link {
            font-size: 0.9rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            border: none;
            background: transparent;
            padding: 8px 12px;
            border-bottom: 3px solid transparent;
        }
        .left-tabs .nav-link.active {
            color: #1e293b;
            border-bottom: 3px solid var(--primary);
        }
        
        /* Main News Overlay */
        .main-news-container {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            height: 500px;
        }
        .main-news-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        .main-news-container:hover .main-news-img {
            transform: scale(1.05);
        }
        .main-news-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 30px;
            background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.6) 50%, transparent 100%);
            color: white;
        }
        .main-news-title {
            font-size: 1.8rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 10px;
            color: white;
            text-decoration: none;
        }
        .main-news-title:hover {
            text-decoration: underline;
        }
        .category-badge {
            background-color: #0d6efd;
            color: white;
            padding: 4px 10px;
            font-size: 0.75rem;
            font-weight: 700;
            border-radius: 4px;
            text-transform: uppercase;
            margin-bottom: 10px;
            display: inline-block;
        }

        .rank-badge {
            position: absolute;
            bottom: -5px;
            right: -5px;
            background-color: #dc3545;
            color: white;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.8rem;
            border-radius: 4px;
            z-index: 2;
        }

        /* Custom Scrollbar for Left and Right columns */
        .scrollable-list {
            max-height: 500px;
            overflow-y: auto;
            padding-right: 5px;
        }
        .scrollable-list::-webkit-scrollbar {
            width: 5px;
        }
        .scrollable-list::-webkit-scrollbar-track {
            background: #f1f5f9; 
            border-radius: 10px;
        }
        .scrollable-list::-webkit-scrollbar-thumb {
            background: #cbd5e1; 
            border-radius: 10px;
        }
        .scrollable-list::-webkit-scrollbar-thumb:hover {
            background: #94a3b8; 
        }
        
        /* Main News Carousel Adjustments */
        .main-news-carousel .carousel-item {
            transition: transform 0.6s ease-in-out;
        }
    </style>

    <div class="row g-4">
        
        <!-- Left Column: Tabs (Latest, Popular, Update) -->
        <div class="col-lg-3 col-md-6 border-end">
            <!-- Custom Tabs -->
            <ul class="nav nav-tabs left-tabs mb-4" id="leftTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="latest-tab" data-bs-toggle="tab" data-bs-target="#latest-pane" type="button" role="tab"><i class="fa-regular fa-clock me-1"></i> LATEST</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="popular-tab" data-bs-toggle="tab" data-bs-target="#popular-pane" type="button" role="tab"><i class="fa-solid fa-bolt me-1"></i> POPULAR</button>
                </li>
            </ul>
            
            <div class="tab-content" id="leftTabsContent">
                <!-- Latest Pane -->
                <div class="tab-pane fade show active scrollable-list" id="latest-pane" role="tabpanel">
                    @forelse($latestBlogs as $blog)
                        <div class="d-flex news-card-small">
                            <a href="{{ route('page.show', $blog->slug) }}" class="flex-shrink-0">
                                <img src="{{ $blog->featured_image ?? asset('assets/images/default-blog.jpg') }}" alt="{{ $blog->title }}" loading="lazy" width="80" height="80" class="news-img-small">
                            </a>
                            <div class="ms-3 flex-grow-1">
                                <a href="{{ route('page.show', $blog->slug) }}" class="news-title-small">{{ $blog->title }}</a>
                                <div class="news-meta-small">
                                    <i class="fa-regular fa-clock"></i> {{ $blog->created_at->format('M j, Y') }} &nbsp; 
                                    <i class="fa-regular fa-comment"></i> 0
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted small">No recent articles.</div>
                    @endforelse
                </div>
                
                <!-- Popular Pane -->
                <div class="tab-pane fade scrollable-list" id="popular-pane" role="tabpanel">
                    @forelse($popularBlogs as $blog)
                        <div class="d-flex news-card-small">
                            <a href="{{ route('page.show', $blog->slug) }}" class="flex-shrink-0">
                                <img src="{{ $blog->featured_image ?? asset('assets/images/default-blog.jpg') }}" alt="{{ $blog->title }}" loading="lazy" width="80" height="80" class="news-img-small">
                            </a>
                            <div class="ms-3 flex-grow-1">
                                <a href="{{ route('page.show', $blog->slug) }}" class="news-title-small">{{ $blog->title }}</a>
                                <div class="news-meta-small">
                                    <i class="fa-regular fa-clock"></i> {{ $blog->created_at->format('M j, Y') }} &nbsp; 
                                    <i class="fa-regular fa-eye"></i> {{ $blog->views }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted small">No popular articles yet.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Center Column: Main News -->
        <div class="col-lg-6 col-md-12 border-end">
            <div class="section-header">
                <h3>MAIN NEWS</h3>
                <div class="d-flex gap-2">
                    <button aria-label="Previous main news" class="btn btn-sm btn-light border" type="button" data-bs-target="#mainNewsCarousel" data-bs-slide="prev"><i class="fa-solid fa-chevron-left text-muted"></i></button>

                    <button aria-label="Next main news" class="btn btn-sm btn-light border" type="button" data-bs-target="#mainNewsCarousel" data-bs-slide="next"><i class="fa-solid fa-chevron-right text-muted"></i></button>
                </div>
            </div>
            
            @if(isset($latestBlogs) && count($latestBlogs) > 0)
            <div id="mainNewsCarousel" class="carousel slide main-news-carousel" data-bs-ride="carousel">
                <div class="carousel-inner rounded-4 shadow-sm">
                    @foreach($latestBlogs->take(5) as $index => $newsItem)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="main-news-container border-0 w-100 m-0">
                            <a href="{{ route('page.show', $newsItem->slug) }}">
                                <img src="{{ $newsItem->featured_image ?? asset('assets/images/default-blog.jpg') }}" alt="{{ $newsItem->title }}" loading="lazy" width="600" height="500" class="main-news-img">
                            </a>
                            <div class="main-news-overlay">
                                <span class="category-badge d-inline-flex align-items-center gap-2" style="width: fit-content;">
                                    @if(isset($newsItem->category) && $newsItem->categories->first()->image ?? '')
                                        <img src="{{ asset($newsItem->categories->first()->image ?? '') }}" alt="{{ $newsItem->categories->first()->name ?? 'News' }}" loading="lazy" width="16" height="16" style="width: 16px; height: 16px; border-radius: 50%; object-fit: cover;">
                                    @endif
                                    {{ $newsItem->categories->first()->name ?? 'News' ?? 'News' }}
                                </span>
                                <a href="{{ route('page.show', $newsItem->slug) }}" class="d-block main-news-title">
                                    {{ $newsItem->title }}
                                </a>
                                <div class="d-flex align-items-center mt-2 small text-light fw-medium opacity-75">
                                    <span class="me-3"><i class="fa-regular fa-circle-user me-1"></i> {{ $newsItem->user->name ?? 'admin' }}</span>
                                    <span class="me-3"><i class="fa-regular fa-clock me-1"></i> {{ $newsItem->created_at->format('F j, Y') }}</span>
                                    <span><i class="fa-regular fa-comment me-1"></i> 0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
                <div class="p-5 text-center bg-light rounded text-muted">No featured news available.</div>
            @endif
        </div>

        <!-- Right Column: Trending Now -->
        <div class="col-lg-3 col-md-6">
            <div class="section-header">
                <h3>TRENDING NOW</h3>
                <div class="d-flex gap-2">
                    <button aria-label="Scroll down trending list" class="btn btn-sm btn-light border"><i class="fa-solid fa-chevron-down text-muted"></i></button>
                    <button aria-label="Scroll up trending list" class="btn btn-sm btn-light border"><i class="fa-solid fa-chevron-up text-muted"></i></button>
                </div>
            </div>
            
            <div class="trending-list scrollable-list">
                @forelse($trendingBlogs as $index => $blog)
                    <div class="d-flex news-card-small">
                        <div class="position-relative flex-shrink-0">
                            <a href="{{ route('page.show', $blog->slug) }}">
                                <img src="{{ $blog->featured_image ?? asset('assets/images/default-blog.jpg') }}" alt="{{ $blog->title }}" loading="lazy" width="80" height="80" class="news-img-small">
                            </a>
                            <div class="rank-badge">{{ $index + 1 }}</div>
                        </div>
                        <div class="ms-3 flex-grow-1">
                            <a href="{{ route('page.show', $blog->slug) }}" class="news-title-small">{{ $blog->title }}</a>
                            <div class="news-meta-small">
                                <i class="fa-regular fa-clock"></i> {{ $blog->created_at->format('M j, Y') }} &nbsp; 
                                <i class="fa-regular fa-comment"></i> 0
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-muted small">No trending articles.</div>
                @endforelse
            </div>
        </div>
        
    </div>
</div>
<!-- More Blogs Grid Layout -->
<div id="more-articles" class="container-fluid px-4 px-xl-5 mb-5 mt-4">
    <div class="section-header mb-4">
        <h3>MORE ARTICLES</h3>
    </div>
    <div class="row g-4">
        @forelse($paginatedBlogs as $blog)
        <div class="col-lg-4 col-md-6">
            <a href="{{ route('page.show', $blog->slug) }}" class="text-decoration-none h-100 d-block">
                <div class="card blog-card h-100 border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
                    <div class="card-img-wrapper position-relative" style="height: 220px; overflow: hidden;">
                        <img src="{{ $blog->featured_image ?? asset('assets/images/default-blog.jpg') }}" alt="{{ $blog->title }}" loading="lazy" width="400" height="220" class="card-img-top w-100 h-100" style="object-fit: cover; transition: transform 0.5s ease;">
                        <span class="badge bg-primary position-absolute top-0 start-0 m-3 rounded-pill px-3 py-2 shadow-sm d-flex align-items-center gap-2" style="width: fit-content;">
                            @if(isset($blog->category) && $blog->categories->first()->image ?? '')
                                <img src="{{ asset($blog->categories->first()->image ?? '') }}" alt="{{ $blog->categories->first()->name ?? 'Uncategorized' }}" loading="lazy" width="16" height="16" style="width: 16px; height: 16px; border-radius: 50%; object-fit: cover;">
                            @endif
                            {{ $blog->categories->first()->name ?? 'Uncategorized' ?? 'Update' }}
                        </span>
                    </div>
                    <div class="card-body p-4 d-flex flex-column bg-white">
                        <h5 class="card-title fw-bold text-dark mb-3" style="font-size: 1.25rem; line-height: 1.4; transition: color 0.3s;">{{ Str::limit($blog->title, 60) }}</h5>
                        <p class="card-text text-muted small mb-4">{{ Str::limit($blog->excerpt, 100) }}</p>
                        <div class="mt-auto d-flex align-items-center justify-content-between border-top pt-3">
                            <div class="d-flex align-items-center">
                                <i class="fa-regular fa-circle-user text-primary me-2"></i>
                                <small class="text-muted fw-semibold">{{ $blog->user->name ?? 'Admin' }}</small>
                            </div>
                            <small class="text-muted"><i class="fa-regular fa-calendar-days me-1"></i> {{ $blog->created_at->format('M d, Y') }}</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12 text-center text-muted">No more articles available.</div>
        @endforelse
    </div>
    <div class="d-flex justify-content-center mt-5">
        {{ $paginatedBlogs->links('pagination::bootstrap-5') }}
    </div>
</div>
<!-- Premium Real Estate CTA Section -->
<div class="container-fluid px-4 px-xl-5 my-5">
    <div class="card border-0 shadow-lg position-relative overflow-hidden" style="border-radius: 24px; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
        <!-- Decorative Background Elements -->
        <div class="position-absolute" style="top: -50%; left: -10%; width: 50%; height: 200%; background: radial-gradient(circle, rgba(212,175,55,0.15) 0%, rgba(212,175,55,0) 70%); transform: rotate(30deg); pointer-events: none;"></div>
        <div class="position-absolute" style="bottom: -50%; right: -10%; width: 40%; height: 200%; background: radial-gradient(circle, rgba(212,175,55,0.1) 0%, rgba(212,175,55,0) 70%); transform: rotate(-30deg); pointer-events: none;"></div>
        
        <div class="card-body p-5 position-relative z-index-1">
            <div class="row align-items-center">
                <div class="col-lg-7 mb-4 mb-lg-0 text-center text-lg-start">
                    <span class="badge rounded-pill mb-3 px-3 py-2" style="background: rgba(212,175,55,0.2); color: #d4af37; border: 1px solid rgba(212,175,55,0.5); font-weight: 600; letter-spacing: 1px;">{{ App\Models\Setting::getValue('cta_badge', 'EXCLUSIVE REAL ESTATE DEALS') }}</span>
                    <h2 class="fw-bolder text-white mb-3" style="font-size: 2.5rem; line-height: 1.2;">{!! App\Models\Setting::getValue('cta_title', 'Looking for the Best Property Investment?') !!}</h2>
                    <p class="text-white-50 fs-5 mb-4" style="max-width: 600px;">{!! App\Models\Setting::getValue('cta_subtitle', 'Get a free consultation with our experts and discover premium residential flats, townships, and commercial spaces with assured returns.') !!}</p>
                    
                    <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                        <div class="d-flex align-items-center text-white-50" style="font-size: 0.9rem;">
                            <i class="fa-solid fa-check-circle me-2" style="color: #d4af37;"></i> 100% Free Consultation
                        </div>
                        <div class="d-flex align-items-center text-white-50" style="font-size: 0.9rem;">
                            <i class="fa-solid fa-check-circle me-2" style="color: #d4af37;"></i> Verified Properties
                        </div>
                        <div class="d-flex align-items-center text-white-50" style="font-size: 0.9rem;">
                            <i class="fa-solid fa-check-circle me-2" style="color: #d4af37;"></i> High ROI Guaranteed
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-5 text-center text-lg-end">
                    <div class="bg-white p-4 rounded-4 shadow d-inline-block text-center w-100" style="max-width: 400px;">
                        <h4 class="fw-bold text-dark mb-2">{{ App\Models\Setting::getValue('cta_box_title', 'Speak to an Expert') }}</h4>
                        <p class="text-muted small mb-4">{{ App\Models\Setting::getValue('cta_box_subtitle', 'Book your VIP session today before prices increase.') }}</p>
                                                
                        <a href="{{ App\Models\Setting::getValue('cta_btn_link', route('page.show', 'contact')) }}" class="btn w-100 py-3 fw-bold text-dark d-flex align-items-center justify-content-center gap-2" style="background: linear-gradient(45deg, #d4af37, #f3e5ab); border: none; border-radius: 12px; font-size: 1.1rem; transition: transform 0.2s; box-shadow: 0 4px 15px rgba(212,175,55,0.3);">
                            <i class="fa-solid fa-calendar-check"></i> {{ App\Models\Setting::getValue('cta_btn_text', 'Request a Call Back') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
