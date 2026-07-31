@extends('admin.layout')
@section('title', 'Footer Settings')
@section('content')
<h2 class="fw-bold mb-4">Footer & Social Settings</h2>
@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-4">
                <label class="form-label fw-bold">Footer Logo</label>
                @if(isset($settings['footer_logo']) && !empty($settings['footer_logo']))
                    <div class="mb-2">
                        <img src="{{ $settings['footer_logo'] }}" alt="Footer Logo" style="max-height: 80px; object-fit: contain; background: #333; padding: 10px; border-radius: 8px;">
                    </div>
                @endif
                <input type="file" name="footer_logo_file" class="form-control" accept="image/*">
                <small class="text-muted">Upload a logo to display in the footer instead of the site name. (Transparent PNG recommended for dark background)</small>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Footer About Text</label>
                <textarea name="footer_text" class="form-control" rows="4">{{ $settings['footer_text'] ?? '' }}</textarea>
            </div>
            
            <h5 class="fw-bold text-primary mb-3">Social Links</h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Facebook Link</label>
                    <input type="url" name="facebook" class="form-control" value="{{ $settings['facebook'] ?? '' }}" placeholder="https://facebook.com/...">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Twitter Link</label>
                    <input type="url" name="twitter" class="form-control" value="{{ $settings['twitter'] ?? '' }}" placeholder="https://twitter.com/...">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Instagram Link</label>
                    <input type="url" name="instagram" class="form-control" value="{{ $settings['instagram'] ?? '' }}" placeholder="https://instagram.com/...">
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg mt-4 px-5 fw-bold rounded-pill">Save Footer Settings</button>
        </form>
    </div>
</div>
@endsection