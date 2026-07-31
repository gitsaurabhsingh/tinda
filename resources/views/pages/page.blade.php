@extends('layouts.app')
@section('title', $page->title . ' - ' . ($settings['site_name'] ?? 'Tindablog'))
@if($page->meta_description)
    @section('meta_description', $page->meta_description)
@endif

@section('content')
<!-- Page Header -->
@if($page->image)
@php
    $bgUrl = Str::startsWith($page->image, ['http', '/storage']) ? $page->image : '/storage/' . $page->image;
@endphp
<div class="page-header text-white text-center position-relative overflow-hidden" style="height: 60vh; min-height: 500px; display: flex; align-items: center;">
    <!-- Animated Background Image -->
    <div class="banner-bg-animated position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset($bgUrl) }}'); background-size: cover; background-position: center;"></div>
    
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(30,27,75,0.6), rgba(15,23,42,0.6)); z-index: 1;"></div>
    
    <div class="container position-relative w-100" style="z-index: 2;" data-aos="zoom-out" data-aos-duration="1200">
        <h1 class="display-2 fw-bolder mb-3 text-white drop-shadow-lg" style="letter-spacing: -1px; text-transform: uppercase;">{{ $page->title }}</h1>
        <div class="d-flex justify-content-center align-items-center">
            <span class="badge rounded-pill bg-white text-dark px-4 py-2 shadow-sm d-flex align-items-center fw-bold">
                <a href="{{ url('/') }}" class="text-dark text-decoration-none me-2">Home</a>
                <i class="fa-solid fa-chevron-right text-primary me-2" style="font-size: 0.7rem;"></i>
                <span class="text-primary">{{ $page->title }}</span>
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
        <h1 class="display-2 fw-bolder mb-3 text-white drop-shadow-lg" style="letter-spacing: -1px; text-transform: uppercase;">{{ $page->title }}</h1>
        <div class="d-flex justify-content-center align-items-center">
            <span class="badge rounded-pill bg-white text-dark px-4 py-2 shadow-sm d-flex align-items-center fw-bold">
                <a href="{{ url('/') }}" class="text-dark text-decoration-none me-2">Home</a>
                <i class="fa-solid fa-chevron-right text-primary me-2" style="font-size: 0.7rem;"></i>
                <span class="text-primary">{{ $page->title }}</span>
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

<!-- Page Content -->
<div class="container py-5 my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="page-content bg-white p-4 p-md-5 rounded-4 shadow-sm">

                {!! $page->content !!}
            </div>
        </div>
    </div>
</div>

<style>
    .page-content {
        line-height: 1.8;
        font-size: 1.1rem;
        color: #4b5563;
    }
    .page-content h1, .page-content h2, .page-content h3 {
        color: #1f2937;
        font-weight: 700;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
    .page-content p {
        margin-bottom: 1.5rem;
    }
    .page-content img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        margin: 1.5rem 0;
    }
</style>
@endsection
