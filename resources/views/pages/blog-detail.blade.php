@extends('layouts.app')

@section('title', $blog->seo_title ?? $blog->title)
@section('meta_description', $blog->seo_description ?? Str::limit(strip_tags($blog->excerpt ?? $blog->content), 155))

@section('content')
<!-- Reading Progress Bar -->
<div id="reading-progress-bar" style="position: fixed; top: 0; left: 0; width: 0%; height: 4px; background: linear-gradient(90deg, #4f46e5, #06b6d4); z-index: 9999; transition: width 0.1s ease;"></div>

<div class="container py-5" style="margin-top: 20px;">
    <div class="row">
        <!-- Main Content Area (Left) -->
        <div class="col-lg-8">
            <!-- Title and Full Image -->
            <div class="mb-4">
                <span class="badge bg-primary px-3 py-2 rounded-pill mb-3 text-uppercase fw-bold">{{ $blog->categories->first()->name ?? 'Uncategorized' }}</span>
                <h1 class="fw-bolder mb-4" style="color: #0f172a; font-size: 2.5rem; line-height: 1.2;">{{ $blog->title }}</h1>
                
                <!-- Pure uncropped image on top -->
                <img src="{{ $blog->featured_image }}" alt="{{ $blog->title }}" width="800" height="600" class="img-fluid rounded-4 shadow-sm w-100 mb-4" style="object-fit: contain; max-height: 600px; background-color: #f8fafc;">
            </div>

            <!-- Content Card -->
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white mb-5">
                <div class="blog-content">
                    {!! $blog->content !!}
                </div>
                
                <!-- Gallery Section -->
                @php 
                    $gallery = $blog->gallery_images ? json_decode($blog->gallery_images) : []; 
                @endphp
                @if(!empty($gallery) && count($gallery) > 1)
                    <div class="mt-5 pt-4 border-top">
                        <h4 class="fw-bold mb-4" style="color: #0f172a;">Image Gallery</h4>
                        <div class="row g-3">
                            @foreach($gallery as $index => $img)
                                <div class="col-md-6 col-lg-4">
                                    <div class="rounded-4 overflow-hidden shadow-sm h-100" style="background-color: #f8fafc; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageLightboxModal" onclick="openLightbox({{ $index }})">
                                        <img src="{{ $img }}" class="w-100 h-100" style="object-fit: cover; min-height: 200px; max-height: 250px; transition: transform 0.3s ease;" loading="lazy" width="400" height="250" alt="Gallery Image {{ $index + 1 }}" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @elseif(!empty($gallery) && count($gallery) == 1)
                     <div class="mt-5 pt-4 border-top">
                         <h4 class="fw-bold mb-4" style="color: #0f172a;">Additional Image</h4>
                         <img src="{{ $gallery[0] }}" alt="Additional image for {{ $blog->title }}" loading="lazy" width="800" height="500" class="img-fluid rounded-4 shadow-sm w-100 cursor-pointer" style="object-fit: contain; max-height: 500px; background-color: #f8fafc; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageLightboxModal" onclick="openLightbox(0)">
                     </div>
                @endif
            </div>
        </div>
        
        <!-- Sidebar Area (Right Side) -->
        <div class="col-lg-4 mt-5 mt-lg-0">
            <div style="position: sticky; top: 100px;">
                
                <!-- Article Info Card -->
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4" style="background: linear-gradient(135deg, #ffffff, #f8fafc);">
                    <h5 class="fw-bold border-bottom pb-3 mb-4">Article Details</h5>
                    
                    <div class="d-flex align-items-center mb-4">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($blog->user->name) }}&background=4f46e5&color=fff" alt="{{ $blog->user->name }} profile" loading="lazy" class="rounded-circle me-3 shadow-sm" width="50" height="50">
                        <div>
                            <span class="d-block text-muted small">Posted by</span>
                            <span class="fw-bold text-dark">{{ $blog->user->name }}</span>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center mb-3 text-muted">
                        <i class="fa-regular fa-calendar text-primary me-3 fs-5"></i>
                        <div>
                            <span class="d-block small">Published on</span>
                            <span class="fw-medium text-dark">{{ $blog->created_at->format('F d, Y') }}</span>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center text-muted">
                        <i class="fa-solid fa-fire text-warning me-3 fs-5"></i>
                        <div>
                            <span class="d-block small">Total Views</span>
                            <span class="fw-medium text-dark">{{ $blog->views }} Views</span>
                        </div>
                    </div>
                </div>

                <!-- Latest Posts Sidebar Widget -->
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold border-bottom pb-3 mb-4">Latest Articles</h5>
                    @php
                        $sidebarBlogs = \App\Models\Blog::where('status', 'approved')->where('id', '!=', $blog->id)->latest()->take(4)->get();
                    @endphp
                    
                    @foreach($sidebarBlogs as $sBlog)
                        <div class="d-flex mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <a href="{{ route('page.show', $sBlog->slug) }}" class="flex-shrink-0">
                                <img src="{{ $sBlog->featured_image }}" alt="{{ $sBlog->title }}" loading="lazy" width="70" height="70" class="rounded" style="width: 70px; height: 70px; object-fit: cover;">
                            </a>
                            <div class="ms-3">
                                <a href="{{ route('page.show', $sBlog->slug) }}" class="text-dark fw-bold text-decoration-none d-block mb-1" style="font-size: 0.9rem; line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $sBlog->title }}
                                </a>
                                <span class="text-muted small"><i class="fa-regular fa-clock me-1"></i>{{ $sBlog->created_at->format('M d') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                
            </div>
        </div>
    </div>
</div>

<script>
    // Reading Progress Bar Logic
    window.onscroll = function() {
        var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        var scrolled = (winScroll / height) * 100;
        document.getElementById("reading-progress-bar").style.width = scrolled + "%";
    };
</script>

<style>
    /* Styling adjustments for blog content typography (Advanced Premium Look) */
    .blog-content { 
        font-size: 1.15rem !important; 
        line-height: 1.8; 
        color: #334155 !important; 
        font-family: 'Georgia', serif; 
    }

    .blog-content h2, .blog-content h3 { 
        color: #0f172a; 
        font-weight: 800; 
        margin-top: 2.5rem; 
        margin-bottom: 1.25rem; 
        font-family: 'Outfit', sans-serif; 
        letter-spacing: -0.02em;
    }
    .blog-content p { margin-bottom: 1.5rem; }
    .blog-content img { 
        border-radius: 12px; 
        box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
        max-width: 100%; 
        height: auto; 
        margin: 2rem 0; 
    }
    .blog-content blockquote { 
        border-left: 5px solid var(--primary); 
        background: #f8fafc; 
        padding: 1.5rem; 
        margin: 2rem 0; 
        font-style: italic; 
        font-size: 1.2rem;
        border-radius: 0 12px 12px 0; 
        color: #475569;
    }
</style>
        <!-- Related Articles -->
        @if(isset($relatedBlogs) && $relatedBlogs->count() > 0)
        <div class="container pb-5">
            <div class="mt-5 pt-4 border-top" data-aos="fade-up">
            <h4 class="fw-bolder mb-4">You May Also Like</h4>
            <div class="row g-4">
                @foreach($relatedBlogs as $related)
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 hover-scale" style="transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <a href="{{ route('page.show', $related->slug) }}" class="text-decoration-none">
                            <img src="{{ $related->featured_image ?? asset('assets/images/default-blog.jpg') }}" loading="lazy" width="400" height="180" class="card-img-top rounded-top-4" alt="{{ $related->title }}" style="height: 180px; object-fit: cover;">
                            <div class="card-body p-4">
                                <span class="badge bg-primary rounded-pill mb-2">{{ $related->categories->first()->name ?? 'News' }}</span>
                                <h6 class="card-title fw-bold text-dark">{{ Str::limit($related->title, 50) }}</h6>
                                <p class="text-muted small mb-0"><i class="fa-regular fa-clock me-1"></i> {{ $related->created_at->format('M d, Y') }}</p>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            </div>
        </div>
        @endif
@endsection

<!-- Lightbox Modal -->
<div class="modal fade" id="imageLightboxModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content bg-transparent border-0">
      <div class="modal-header border-0 pb-0" style="z-index: 1055;">
        <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1) grayscale(100%) brightness(200%);"></button>
      </div>
      <div class="modal-body text-center p-0 position-relative">
        <button id="lightboxPrev" aria-label="Previous image" class="btn btn-dark position-absolute top-50 start-0 translate-middle-y ms-2 rounded-circle shadow" style="width: 45px; height: 45px; z-index: 1055; opacity: 0.8;" onclick="changeLightboxImage(-1)">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        
        <img id="lightboxImage" src="" alt="Lightbox full screen image" class="img-fluid rounded shadow-lg" style="max-height: 85vh;">
        
        <button id="lightboxNext" aria-label="Next image" class="btn btn-dark position-absolute top-50 end-0 translate-middle-y me-2 rounded-circle shadow" style="width: 45px; height: 45px; z-index: 1055; opacity: 0.8;" onclick="changeLightboxImage(1)">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
      </div>
    </div>
  </div>
</div>

<script>
    const galleryImages = @json(!empty($gallery) ? $gallery : []);
    let currentLightboxIndex = 0;

    function openLightbox(index) {
        if(galleryImages.length === 0) return;
        currentLightboxIndex = index;
        document.getElementById('lightboxImage').src = galleryImages[currentLightboxIndex];
        
        // Hide arrows if there is only 1 image
        if(galleryImages.length <= 1) {
            document.getElementById('lightboxPrev').style.display = 'none';
            document.getElementById('lightboxNext').style.display = 'none';
        } else {
            document.getElementById('lightboxPrev').style.display = 'block';
            document.getElementById('lightboxNext').style.display = 'block';
        }
    }

    function changeLightboxImage(direction) {
        if(galleryImages.length <= 1) return;
        
        currentLightboxIndex += direction;
        
        // Loop around
        if (currentLightboxIndex < 0) {
            currentLightboxIndex = galleryImages.length - 1;
        } else if (currentLightboxIndex >= galleryImages.length) {
            currentLightboxIndex = 0;
        }
        
        document.getElementById('lightboxImage').src = galleryImages[currentLightboxIndex];
    }
</script>