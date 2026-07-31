<?php
$content = file_get_contents('resources/views/welcome.blade.php');

$startMarker = '<!-- Modern Featured Blogs Section -->';
$endMarker = '<!-- Magazine Style 3-Column Layout -->';

$startSection = strpos($content, $startMarker);
$endSection = strpos($content, $endMarker);

if ($startSection !== false && $endSection !== false) {
    // Already has an empty space or half broken HTML, let's restore it
}

// Actually since I deleted the block (it was replaced with empty string),
// I need to search for where to insert it.
// It goes before <!-- Magazine Style 3-Column Layout -->

$insertPos = strpos($content, '<!-- Magazine Style 3-Column Layout -->');
if ($insertPos !== false) {
    $featuredHTML = <<<'EOT'
<!-- Modern Featured Blogs Section -->
@if(isset($featuredBlogs) && count($featuredBlogs) > 0)
<div class="container position-relative" style="margin-top: 10px; z-index: 10;" data-aos="fade-up" data-aos-delay="200">
    <div class="card border-0 shadow-lg" style="border-radius: 20px; background: rgba(255,255,255,0.9); backdrop-filter: blur(10px);">
        <div class="card-body p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bolder m-0 text-dark"><i class="fa-solid fa-fire text-danger me-2"></i> Featured Articles</h4>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-dark rounded-circle d-flex align-items-center justify-content-center" id="scrollLeftBtn" style="width: 45px; height: 45px; transition: all 0.3s;"><i class="fa-solid fa-chevron-left"></i></button>
                    <button class="btn btn-outline-dark rounded-circle d-flex align-items-center justify-content-center" id="scrollRightBtn" style="width: 45px; height: 45px; transition: all 0.3s;"><i class="fa-solid fa-chevron-right"></i></button>
                </div>
            </div>
            
            <div class="featured-carousel-container pb-2" id="featuredCarousel" style="overflow-x: auto; overflow-y: hidden; white-space: nowrap; scroll-behavior: smooth; -webkit-overflow-scrolling: touch; -ms-overflow-style: none; scrollbar-width: none;">
                <style>
                    /* Hide scrollbar for cleaner look */
                    .featured-carousel-container::-webkit-scrollbar { display: none; }
                    
                    .mini-blog-card {
                        display: inline-block;
                        width: 300px;
                        margin-right: 25px;
                        white-space: normal;
                        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
                        vertical-align: top;
                    }
                    .mini-blog-card:hover {
                        transform: translateY(-10px);
                    }
                    .mini-blog-card:hover .mini-blog-img {
                        transform: scale(1.08);
                    }
                    .mini-blog-card:hover .card-title {
                        color: var(--primary) !important;
                    }
                </style>
                
                @foreach($featuredBlogs as $blog)
                <div class="mini-blog-card">
                    <a href="{{ route('page.show', $blog->slug) }}" class="text-decoration-none">
                        <div class="card border-0 rounded-4 shadow-sm h-100 overflow-hidden bg-white" style="border: 1px solid rgba(0,0,0,0.05) !important;">
                            <div class="position-relative overflow-hidden" style="height: 180px;">
                                <img src="{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : asset('assets/images/default-blog.jpg') }}" alt="{{ $blog->title }}" class="img-fluid w-100 h-100 mini-blog-img" style="object-fit: cover; transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);">
                                <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to bottom, rgba(0,0,0,0) 50%, rgba(0,0,0,0.7) 100%);"></div>
                                <span class="badge bg-primary position-absolute bottom-0 start-0 m-3 rounded-pill px-3 py-2 shadow-sm" style="font-size: 0.75rem; font-weight: 600;">{{ $blog->category->name ?? 'Update' }}</span>
                            </div>
                            <div class="card-body p-4 d-flex flex-column justify-content-between" style="min-height: 130px;">
                                <h5 class="card-title fw-bold text-dark mb-3 text-wrap" style="font-size: 1.1rem; line-height: 1.4; transition: color 0.3s;">{{ Str::limit($blog->title, 55) }}</h5>
                                <div class="d-flex align-items-center justify-content-between mt-auto">
                                    <small class="text-muted fw-semibold" style="font-size: 0.8rem;"><i class="fa-regular fa-calendar-days me-2"></i>{{ $blog->created_at->format('M d, Y') }}</small>
                                    <small class="text-muted fw-semibold" style="font-size: 0.8rem;"><i class="fa-regular fa-eye me-1"></i>{{ $blog->views ?? 0 }}</small>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const carousel = document.getElementById('featuredCarousel');
                    const leftBtn = document.getElementById('scrollLeftBtn');
                    const rightBtn = document.getElementById('scrollRightBtn');
                    
                    if(carousel && leftBtn && rightBtn) {
                        leftBtn.addEventListener('click', () => {
                            carousel.scrollBy({ left: -325, behavior: 'smooth' });
                        });
                        rightBtn.addEventListener('click', () => {
                            carousel.scrollBy({ left: 325, behavior: 'smooth' });
                        });
                    }
                });
            </script>
        </div>
    </div>
</div>
@endif

EOT;
    $content = substr($content, 0, $insertPos) . $featuredHTML . substr($content, $insertPos);
    file_put_contents('resources/views/welcome.blade.php', $content);
    echo "Fixed and inserted featured carousel.\n";
}
