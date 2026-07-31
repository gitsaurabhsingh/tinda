<?php
$content = file_get_contents('resources/views/welcome.blade.php');

$startMarker = '<!-- Modern Explore Topics Section -->';
$endMarker = '@endif'; // The one after <!-- Modern Explore Topics Section -->

$start = strpos($content, $startMarker);
if ($start !== false) {
    // find the first @endif after the start marker
    $end = strpos($content, $endMarker, $start);
    if ($end !== false) {
        $end += strlen($endMarker); // include @endif
        
        $featuredHTML = <<<'EOT'
<!-- Modern Featured Blogs Section -->
@if(isset($featuredBlogs) && count($featuredBlogs) > 0)
<div class="container position-relative" style="margin-top: 10px; z-index: 10;" data-aos="fade-up" data-aos-delay="200">
    <div class="card border-0 shadow-lg" style="border-radius: 20px; background: rgba(255,255,255,0.9); backdrop-filter: blur(10px);">
        <div class="card-body p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bolder m-0 text-dark"><i class="fa-solid fa-star text-warning me-2"></i> Featured Articles</h4>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary rounded-circle" id="scrollLeftBtn" style="width: 40px; height: 40px;"><i class="fa-solid fa-chevron-left"></i></button>
                    <button class="btn btn-outline-primary rounded-circle" id="scrollRightBtn" style="width: 40px; height: 40px;"><i class="fa-solid fa-chevron-right"></i></button>
                </div>
            </div>
            
            <div class="featured-carousel-container" id="featuredCarousel" style="overflow-x: auto; overflow-y: hidden; white-space: nowrap; padding-bottom: 15px; scroll-behavior: smooth; -webkit-overflow-scrolling: touch;">
                <style>
                    .featured-carousel-container::-webkit-scrollbar { height: 6px; }
                    .featured-carousel-container::-webkit-scrollbar-track { background: rgba(0,0,0,0.05); border-radius: 10px; }
                    .featured-carousel-container::-webkit-scrollbar-thumb { background: var(--secondary); border-radius: 10px; }
                    
                    .mini-blog-card {
                        display: inline-block;
                        width: 320px;
                        margin-right: 20px;
                        white-space: normal;
                        transition: all 0.3s ease;
                        vertical-align: top;
                    }
                    .mini-blog-card:hover {
                        transform: translateY(-8px);
                    }
                    .mini-blog-card:hover .mini-blog-img {
                        transform: scale(1.05);
                    }
                </style>
                
                @foreach($featuredBlogs as $blog)
                <div class="mini-blog-card">
                    <a href="{{ route('page.show', $blog->slug) }}" class="text-decoration-none">
                        <div class="card border-0 rounded-4 shadow-sm h-100 overflow-hidden bg-white">
                            <div class="row g-0">
                                <div class="col-4 overflow-hidden">
                                    <img src="{{ $blog->image ? asset('storage/' . $blog->image) : asset('assets/images/default-blog.jpg') }}" alt="{{ $blog->title }}" class="img-fluid h-100 w-100 mini-blog-img" style="object-fit: cover; transition: transform 0.5s ease; min-height: 100px;">
                                </div>
                                <div class="col-8">
                                    <div class="card-body p-3 d-flex flex-column justify-content-center h-100">
                                        <span class="badge bg-light text-primary rounded-pill mb-2 align-self-start" style="font-size: 0.7rem;">{{ $blog->category->name ?? 'Update' }}</span>
                                        <h6 class="card-title fw-bold text-dark mb-1" style="font-size: 0.95rem; line-height: 1.3;">{{ Str::limit($blog->title, 40) }}</h6>
                                        <small class="text-muted" style="font-size: 0.75rem;"><i class="fa-regular fa-calendar me-1"></i>{{ $blog->created_at->format('M d') }}</small>
                                    </div>
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
                            carousel.scrollBy({ left: -340, behavior: 'smooth' });
                        });
                        rightBtn.addEventListener('click', () => {
                            carousel.scrollBy({ left: 340, behavior: 'smooth' });
                        });
                    }
                });
            </script>
        </div>
    </div>
</div>
@endif
EOT;
        
        $content = substr($content, 0, $start) . $featuredHTML . substr($content, $end);
        file_put_contents('resources/views/welcome.blade.php', $content);
        echo "Replaced Explore Topics with Featured Blogs Carousel.\n";
    }
}
