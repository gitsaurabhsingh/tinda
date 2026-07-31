<?php
$content = file_get_contents('resources/views/welcome.blade.php');

$gridSection = <<<'HTML'
<!-- More Blogs Grid Layout -->
<div class="container-fluid px-4 px-xl-5 mb-5 mt-4">
    <div class="section-header mb-4">
        <h3>MORE ARTICLES</h3>
    </div>
    <div class="row g-4">
        @forelse($latestBlogs->take(6) as $blog)
        <div class="col-lg-4 col-md-6">
            <a href="{{ route('page.show', $blog->slug) }}" class="text-decoration-none h-100 d-block">
                <div class="card blog-card h-100 border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
                    <div class="card-img-wrapper position-relative" style="height: 220px; overflow: hidden;">
                        <img src="{{ $blog->featured_image ?? asset('assets/images/default-blog.jpg') }}" alt="{{ $blog->title }}" class="card-img-top w-100 h-100" style="object-fit: cover; transition: transform 0.5s ease;">
                        <span class="badge bg-primary position-absolute top-0 start-0 m-3 rounded-pill px-3 py-2 shadow-sm">{{ $blog->category->name ?? 'Update' }}</span>
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
</div>
HTML;

$content = str_replace('<!-- Premium Real Estate CTA Section -->', $gridSection . "\n<!-- Premium Real Estate CTA Section -->", $content);

file_put_contents('resources/views/welcome.blade.php', $content);
echo "Added more blogs grid section.";
