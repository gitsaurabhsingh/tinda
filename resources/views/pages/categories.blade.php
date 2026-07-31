@extends('layouts.app')
@section('title', 'Explore Categories')
@section('content')

<!-- Animated Banner Hero -->
<section class="position-relative overflow-hidden" style="height: 60vh; min-height: 450px;">
    <!-- Animated Background Image -->
    <div class="banner-bg-animated position-absolute top-0 start-0 w-100 h-100" style="background: url('https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?ixlib=rb-4.0.3&auto=format&fit=crop&w=2075&q=80') center/cover no-repeat;"></div>
    
    <!-- Deep Gradient Overlay -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(15, 23, 42, 0.5) 0%, rgba(15, 23, 42, 0.1) 100%);"></div>
    
    <div class="container h-100 position-relative z-index-2 d-flex flex-column justify-content-center align-items-center text-center text-white" data-aos="zoom-out" data-aos-duration="1200">
        <span class="badge rounded-pill bg-white text-dark px-4 py-2 fw-bold mb-4 shadow-lg text-uppercase" style="letter-spacing: 2px;">
            <i class="fa-solid fa-shapes text-primary me-2"></i> Topics & Categories
        </span>
        <h1 class="display-2 fw-bolder mb-3 text-white drop-shadow-lg" style="letter-spacing: -2px;">Explore By Topic</h1>
        <p class="lead mx-auto text-white-50" style="max-width: 600px;">
            Browse our curated collection of articles, insights, and stories across various topics tailored for you.
        </p>
    </div>
    <!-- Animated SVG Wave Divider -->
    <div class="position-absolute bottom-0 start-0 w-100" style="height: 100px; overflow: hidden; line-height: 0;">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="width: 100%; height: 100px; display: block; transform: rotate(180deg);">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="#f8f9fa"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="#f8f9fa"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="#f8f9fa"></path>
        </svg>
    </div>
</section>

<!-- Categories Grid -->
<div class="container py-5 mb-5">
    <div class="row g-4 justify-content-center">
        @forelse($categories as $index => $category)
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">
            <a href="{{ route('blog.category', $category->slug) }}" class="text-decoration-none d-block h-100">
                <div class="card premium-category-card h-100 border-0 bg-white">
                    
                    <!-- Image Wrapper -->
                    <div class="card-img-wrapper position-relative overflow-hidden">
                        @if($category->image)
                            <img src="{{ asset($category->image) }}" class="category-image w-100 h-100" alt="{{ $category->name }}" loading="lazy" width="400" height="300">
                        @else
                            <!-- Fallback pattern -->
                            <div class="category-image w-100 h-100 fallback-gradient-{{ $index % 3 }} d-flex align-items-center justify-content-center">
                                <h1 class="display-1 fw-bold text-white opacity-50 m-0">{{ substr($category->name, 0, 1) }}</h1>
                            </div>
                        @endif
                        
                        <!-- Article Count Badge -->
                        @php $articleCount = $category->blogs()->where('status', 'approved')->count(); @endphp
                        <div class="position-absolute top-0 end-0 m-3 z-index-2">
                            <span class="badge bg-white text-dark shadow-sm rounded-pill px-3 py-2 fw-bold d-flex align-items-center gap-2">
                                <div class="pulse-dot"></div> {{ $articleCount }} {{ $articleCount === 1 ? 'Article' : 'Articles' }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <h4 class="fw-bolder mb-2 text-dark">{{ $category->name }}</h4>
                            <p class="text-muted small mb-0 line-clamp-2">
                                Discover all the latest updates, guides, and trends related to {{ $category->name }}.
                            </p>
                        </div>
                        <div class="mt-4 pt-3 border-top d-flex align-items-center justify-content-between">
                            <span class="fw-bold text-primary small text-uppercase" style="letter-spacing: 1px;">View Collection</span>
                            <div class="arrow-btn">
                                <i class="fa-solid fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="py-5 bg-light rounded-4 border border-dashed">
                <i class="fa-solid fa-folder-open text-muted mb-3" style="font-size: 3rem;"></i>
                <h4 class="fw-bold text-dark">No Categories Found</h4>
                <p class="text-muted mb-0">Topics have not been created yet. Check back soon.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>

<style>
/* Background Pattern */
.bg-grid-pattern {
    background-size: 40px 40px;
    background-image: linear-gradient(to right, rgba(0, 0, 0, 0.05) 1px, transparent 1px),
                      linear-gradient(to bottom, rgba(0, 0, 0, 0.05) 1px, transparent 1px);
    mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 0%, rgba(0,0,0,0) 100%);
    -webkit-mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 0%, rgba(0,0,0,0) 100%);
}

/* Premium Card Design */
.premium-category-card {
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    overflow: hidden;
}

.premium-category-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.08);
}

/* Image Hover Zoom */
.card-img-wrapper {
    height: 240px;
    border-radius: 20px 20px 0 0;
}
.category-image {
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
}
.premium-category-card:hover .category-image {
    transform: scale(1.08);
}

/* Fallback Gradients */
.fallback-gradient-0 { background: linear-gradient(135deg, #3b82f6, #8b5cf6); }
.fallback-gradient-1 { background: linear-gradient(135deg, #10b981, #14b8a6); }
.fallback-gradient-2 { background: linear-gradient(135deg, #f59e0b, #ef4444); }

/* Animated Pulse Dot */
.pulse-dot {
    width: 8px;
    height: 8px;
    background-color: #10b981;
    border-radius: 50%;
    box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
    70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
}

/* Arrow Button Animation */
.arrow-btn {
    width: 36px;
    height: 36px;
    background: #f8fafc;
    color: #64748b;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}
.premium-category-card:hover .arrow-btn {
    background: var(--bs-primary);
    color: #fff;
    transform: translateX(5px);
}

.border-dashed {
    border-style: dashed !important;
    border-width: 2px !important;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Banner Animations */
.banner-bg-animated {
    animation: panZoom 25s infinite alternate ease-in-out;
}

@keyframes panZoom {
    0% { transform: scale(1.0) translate(0, 0); }
    100% { transform: scale(1.15) translate(-2%, -2%); }
}

.drop-shadow-lg {
    text-shadow: 0 10px 20px rgba(0,0,0,0.4);
}
</style>
@endsection