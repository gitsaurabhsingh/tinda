@extends('admin.layout')
@section('title', 'Header Settings')
@section('content')
<h2 class="fw-bold mb-4 text-dark">Header & Branding Settings</h2>

@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-4">
                <label class="form-label fw-bold">Site Name (Text Logo)</label>
                <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? 'Tindablog' }}">
                <small class="text-muted">This will be displayed if no logo image is uploaded.</small>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold">Site Logo Image</label>
                @if(isset($settings['site_logo']) && !empty($settings['site_logo']))
                    <div class="mb-3">
                        <img src="{{ $settings['site_logo'] }}" alt="Current Logo" style="max-height: 60px; background: #f8fafc; padding: 10px; border-radius: 10px;">
                    </div>
                @endif
                <input type="file" name="header_logo_file" class="form-control" accept="image/*">
                <small class="text-muted">Upload a transparent PNG for best results. This will replace the Site Name text.</small>
            </div>
            
            <hr class="my-4">
            <h4 class="fw-bold mb-3 text-dark">Navigation Links</h4>
            
            <div class="mb-4">
                <label class="form-label fw-bold">About Us Page Link</label>
                <select name="header_about_slug" class="form-select">
                    <option value="">-- Select About Page --</option>
                    @foreach($pages as $page)
                        <option value="{{ $page->slug }}" {{ ($settings['header_about_slug'] ?? 'about') == $page->slug ? 'selected' : '' }}>{{ $page->title }} ({{ $page->slug }})</option>
                    @endforeach
                </select>
                <small class="text-muted">Select the dynamic page to link in the header for "About Us".</small>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Contact Page Link</label>
                <select name="header_contact_slug" class="form-select">
                    <option value="">-- Select Contact Page --</option>
                    @foreach($pages as $page)
                        <option value="{{ $page->slug }}" {{ ($settings['header_contact_slug'] ?? 'contact') == $page->slug ? 'selected' : '' }}>{{ $page->title }} ({{ $page->slug }})</option>
                    @endforeach
                </select>
                <small class="text-muted">Select the dynamic page to link in the header for "Contact".</small>
            </div>
            
            <hr class="my-4">
            <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">Save Header Settings</button>
        </form>
    </div>
</div>
@endsection