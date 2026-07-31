<?php
$content = file_get_contents('resources/views/pages/blog-detail.blade.php');

$relatedHTML = <<<'EOT'
        <!-- Related Articles -->
        @if(isset($relatedBlogs) && $relatedBlogs->count() > 0)
        <div class="mt-5 pt-4 border-top" data-aos="fade-up">
            <h4 class="fw-bolder mb-4">You May Also Like</h4>
            <div class="row g-4">
                @foreach($relatedBlogs as $related)
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 hover-scale" style="transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <a href="{{ route('page.show', $related->slug) }}" class="text-decoration-none">
                            <img src="{{ $related->featured_image ?? asset('assets/images/default-blog.jpg') }}" class="card-img-top rounded-top-4" alt="{{ $related->title }}" style="height: 180px; object-fit: cover;">
                            <div class="card-body p-4">
                                <span class="badge bg-primary rounded-pill mb-2">{{ $related->category->name ?? 'News' }}</span>
                                <h6 class="card-title fw-bold text-dark">{{ Str::limit($related->title, 50) }}</h6>
                                <p class="text-muted small mb-0"><i class="fa-regular fa-clock me-1"></i> {{ $related->created_at->format('M d, Y') }}</p>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
EOT;

// Insert before the author bio or share section
if (strpos($content, '<!-- Comments Section Placeholder -->') !== false) {
    $content = str_replace('<!-- Comments Section Placeholder -->', $relatedHTML . "\n\n        <!-- Comments Section Placeholder -->", $content);
} else {
    // fallback just append before endsection
    $content = str_replace('@endsection', $relatedHTML . "\n@endsection", $content);
}

file_put_contents('resources/views/pages/blog-detail.blade.php', $content);
echo "Added related blogs.\n";
