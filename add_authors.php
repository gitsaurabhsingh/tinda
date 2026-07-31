<?php
$content = file_get_contents('resources/views/welcome.blade.php');

$topAuthorsHTML = <<<'EOT'
<!-- Top Authors Section -->
@if(isset($topAuthors) && count($topAuthors) > 0)
<div class="container-fluid px-4 px-xl-5 mb-5 mt-5">
    <div class="section-header">
        <h3>TOP WRITERS</h3>
    </div>
    <div class="row g-4">
        @foreach($topAuthors as $author)
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
            <div class="card border-0 shadow-sm rounded-4 text-center p-4 hover-scale" style="transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($author->name) }}&background=0f2a4a&color=fff&size=128" alt="{{ $author->name }}" class="rounded-circle mx-auto mb-3" style="width: 80px; height: 80px; border: 3px solid var(--secondary); padding: 3px;">
                <h5 class="fw-bold mb-1">{{ $author->name }}</h5>
                <span class="badge bg-primary rounded-pill px-3 py-2 mt-2">
                    <i class="fa-solid fa-pen-nib me-1"></i> {{ $author->blogs_count }} Articles
                </span>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Newsletter Subscription Banner -->
<div class="container-fluid px-4 px-xl-5 mb-5 pb-5" data-aos="fade-up">
    <div class="rounded-4 overflow-hidden position-relative p-5 text-center text-white" style="background: linear-gradient(135deg, var(--primary), var(--primary-light));">
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: url('https://www.transparenttextures.com/patterns/cubes.png'); opacity: 0.1;"></div>
        
        <div class="position-relative z-index-1 mx-auto" style="max-width: 600px;">
            <h2 class="fw-bolder mb-3">Stay Updated</h2>
            <p class="lead mb-4 opacity-75">Get the latest articles, exclusive content, and premium insights delivered straight to your inbox.</p>
            
            <form action="{{ route('subscribe') }}" method="POST" class="d-flex gap-2 p-2 bg-white rounded-pill shadow-lg">
                @csrf
                <input type="email" name="email" class="form-control border-0 shadow-none bg-transparent ms-3 text-dark" placeholder="Enter your email address..." required>
                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold" style="background: linear-gradient(135deg, var(--secondary), #d4af37); border: none;">Subscribe</button>
            </form>
            
            @if(session('success'))
                <div class="alert alert-success mt-4 rounded-pill border-0"><i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}</div>
            @endif
        </div>
    </div>
</div>
EOT;

$content = str_replace('@endsection', $topAuthorsHTML . "\n@endsection", $content);
file_put_contents('resources/views/welcome.blade.php', $content);
echo "Added top authors and newsletter.\n";
