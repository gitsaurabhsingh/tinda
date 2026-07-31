@extends('admin.layout')
@section('title', 'Hero Settings')
@section('content')
<h2 class="fw-bold mb-4">Hero Banner Settings</h2>
@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label class="form-label fw-bold">Site Name (Navbar)</label>
                <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? '' }}">
            </div>
            
            <hr class="my-4">
            
            <div class="mb-3">
                <label class="form-label fw-bold">Hero Background Image</label>
                @if(!empty($settings['hero_image']))
                    <div class="mb-2">
                        <img src="{{ $settings['hero_image'] }}" alt="Current Hero" class="img-thumbnail" style="max-height: 150px;">
                    </div>
                @endif
                <input type="file" name="hero_image_file" class="form-control" accept="image/*">
                <small class="text-muted">Select an image from your folder to change the homepage banner.</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Hero Banner Title</label>
                <input type="text" name="hero_title" class="form-control" value="{{ $settings['hero_title'] ?? '' }}">
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Hero Banner Subtitle</label>
                <input type="text" name="hero_subtitle" class="form-control" value="{{ $settings['hero_subtitle'] ?? '' }}">
            </div>
            
            <button type="submit" class="btn btn-primary btn-lg mt-4 px-5 fw-bold rounded-pill">Save Hero Settings</button>
        </form>
    </div>
</div>
@endsection