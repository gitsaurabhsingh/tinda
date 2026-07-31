@extends('layouts.app')
@section('title', 'Contact Us - ' . ($settings['site_name'] ?? 'Tindablog'))

@section('content')
<!-- Page Header -->
@if(isset($page) && $page->image)
@php
    $bgUrl = Str::startsWith($page->image, ['http', '/storage']) ? $page->image : '/storage/' . $page->image;
@endphp
<div class="page-header text-white text-center position-relative overflow-hidden" style="height: 60vh; min-height: 500px; display: flex; align-items: center;">
    <!-- Animated Background Image -->
    <div class="banner-bg-animated position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset($bgUrl) }}'); background-size: cover; background-position: center;"></div>
    
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(30,27,75,0.6), rgba(15,23,42,0.6)); z-index: 1;"></div>
    
    <div class="container position-relative w-100" style="z-index: 2;" data-aos="zoom-out" data-aos-duration="1200">
        <h1 class="display-2 fw-bolder mb-3 text-white drop-shadow-lg" style="letter-spacing: -1px; text-transform: uppercase;">{{ $page->title ?? 'Contact Us' }}</h1>
        <div class="d-flex justify-content-center align-items-center">
            <span class="badge rounded-pill bg-white text-dark px-4 py-2 shadow-sm d-flex align-items-center fw-bold">
                <a href="{{ url('/') }}" class="text-dark text-decoration-none me-2">Home</a>
                <i class="fa-solid fa-chevron-right text-primary me-2" style="font-size: 0.7rem;"></i>
                <span class="text-primary">{{ $page->title ?? 'Contact Us' }}</span>
            </span>
        </div>
    </div>
    <!-- Animated SVG Wave Divider -->
    <div class="position-absolute bottom-0 start-0 w-100" style="height: 100px; overflow: hidden; line-height: 0; z-index: 3;">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="width: 100%; height: 100px; display: block; transform: rotate(180deg);">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="#fdfbfb"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="#fdfbfb"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="#fdfbfb"></path>
        </svg>
    </div>
</div>
@else
<div class="page-header text-white text-center position-relative overflow-hidden" style="height: 60vh; min-height: 500px; display: flex; align-items: center;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(30,27,75,0.9), rgba(15,23,42,0.9)); z-index: 1;"></div>
    <div class="container position-relative w-100" style="z-index: 2;" data-aos="zoom-out" data-aos-duration="1200">
        <h1 class="display-2 fw-bolder mb-3 text-white drop-shadow-lg" style="letter-spacing: -1px; text-transform: uppercase;">{{ $page->title ?? 'Contact Us' }}</h1>
        <div class="d-flex justify-content-center align-items-center">
            <span class="badge rounded-pill bg-white text-dark px-4 py-2 shadow-sm d-flex align-items-center fw-bold">
                <a href="{{ url('/') }}" class="text-dark text-decoration-none me-2">Home</a>
                <i class="fa-solid fa-chevron-right text-primary me-2" style="font-size: 0.7rem;"></i>
                <span class="text-primary">{{ $page->title ?? 'Contact Us' }}</span>
            </span>
        </div>
    </div>
    <!-- Animated SVG Wave Divider -->
    <div class="position-absolute bottom-0 start-0 w-100" style="height: 100px; overflow: hidden; line-height: 0; z-index: 3;">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="width: 100%; height: 100px; display: block; transform: rotate(180deg);">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="#fdfbfb"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="#fdfbfb"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="#fdfbfb"></path>
        </svg>
    </div>
</div>
@endif

<div class="container py-5 my-5">
    <div class="row g-5">
        
        <!-- Contact Information & Dynamic Content -->
        <div class="col-lg-5">
            <div class="pe-lg-4">
                <h2 class="fw-bold mb-4">Get in Touch</h2>
                
                @if($page && $page->content)
                <div class="text-muted mb-5 fs-5">
                    {!! $page->content !!}
                </div>
                @endif
                
                <div class="d-flex align-items-center mb-4 p-4 bg-light rounded-4 shadow-sm border border-secondary border-opacity-10">
                    <div class="icon-box bg-primary text-white d-flex align-items-center justify-content-center rounded-circle shadow me-4" style="width: 60px; height: 60px; font-size: 1.5rem;">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Our Location</h5>
                        <p class="text-muted mb-0">123 Blog Street, Tech City, 10001</p>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-4 p-4 bg-light rounded-4 shadow-sm border border-secondary border-opacity-10">
                    <div class="icon-box bg-primary text-white d-flex align-items-center justify-content-center rounded-circle shadow me-4" style="width: 60px; height: 60px; font-size: 1.5rem;">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Email Us</h5>
                        <p class="text-muted mb-0">contact@tindablog.com</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-lg-7">
            <div class="bg-white p-5 rounded-4 shadow-sm border border-secondary border-opacity-10">
                <h3 class="fw-bold mb-4">Send us a Message</h3>
                
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 p-3 mb-4" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Your Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-lg bg-light border-0 @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="John Doe">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control form-control-lg bg-light border-0 @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="john@example.com">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Subject (Optional)</label>
                            <input type="text" name="subject" class="form-control form-control-lg bg-light border-0 @error('subject') is-invalid @enderror" value="{{ old('subject') }}" placeholder="How can we help you?">
                            @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Your Message <span class="text-danger">*</span></label>
                            <textarea name="message" rows="5" class="form-control bg-light border-0 @error('message') is-invalid @enderror" required placeholder="Write your message here...">{{ old('message') }}</textarea>
                            @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow-sm" style="padding: 15px;">
                                <i class="fa-regular fa-paper-plane me-2"></i> Send Message
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
