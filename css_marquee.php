<?php
$content = file_get_contents('resources/views/welcome.blade.php');

$startMarker = '<div class="featured-carousel-container pb-2" id="featuredCarousel"';
$endMarker = '</script>';

$startSection = strpos($content, $startMarker);
if ($startSection !== false) {
    // Find the end of the script tag that follows
    $endSection = strpos($content, $endMarker, $startSection);
    if ($endSection !== false) {
        $endSection += strlen($endMarker);
        
        $newHTML = <<<'EOT'
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
                    
                    .mini-blog-card {
                        width: 300px;
                        margin-right: 25px;
                        white-space: normal;
                        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
                        flex-shrink: 0;
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
                
                <div class="marquee-content">
                    <!-- First Set -->
                    @foreach($featuredBlogs as $blog)
                    <div class="mini-blog-card">
                        <a href="{{ route('page.show', $blog->slug) }}" class="text-decoration-none">
                            <div class="card border-0 rounded-4 shadow-sm h-100 overflow-hidden bg-white" style="border: 1px solid rgba(0,0,0,0.05) !important;">
                                <div class="position-relative overflow-hidden" style="height: 180px;">
                                    <img src="{{ $blog->featured_image ? asset($blog->featured_image) : 'https://placehold.co/600x400/e2e8f0/475569?text=No+Image' }}" alt="{{ $blog->title }}" class="img-fluid w-100 h-100 mini-blog-img" style="object-fit: cover; transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);">
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
                    
                    <!-- Duplicated Set for Seamless Looping -->
                    @foreach($featuredBlogs as $blog)
                    <div class="mini-blog-card">
                        <a href="{{ route('page.show', $blog->slug) }}" class="text-decoration-none">
                            <div class="card border-0 rounded-4 shadow-sm h-100 overflow-hidden bg-white" style="border: 1px solid rgba(0,0,0,0.05) !important;">
                                <div class="position-relative overflow-hidden" style="height: 180px;">
                                    <img src="{{ $blog->featured_image ? asset($blog->featured_image) : 'https://placehold.co/600x400/e2e8f0/475569?text=No+Image' }}" alt="{{ $blog->title }}" class="img-fluid w-100 h-100 mini-blog-img" style="object-fit: cover; transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);">
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
            </div>
EOT;
        
        $content = substr($content, 0, $startSection) . $newHTML . substr($content, $endSection);
        
        // Also remove the manual buttons since it's a marquee now
        $btnSection = '<div class="d-flex gap-2">
                    <button class="btn btn-outline-dark rounded-circle d-flex align-items-center justify-content-center" id="scrollLeftBtn" style="width: 45px; height: 45px; transition: all 0.3s;"><i class="fa-solid fa-chevron-left"></i></button>
                    <button class="btn btn-outline-dark rounded-circle d-flex align-items-center justify-content-center" id="scrollRightBtn" style="width: 45px; height: 45px; transition: all 0.3s;"><i class="fa-solid fa-chevron-right"></i></button>
                </div>';
        $content = str_replace($btnSection, '', $content);
        
        file_put_contents('resources/views/welcome.blade.php', $content);
        echo "Replaced JS scroll with pure CSS seamless marquee.\n";
    }
}
