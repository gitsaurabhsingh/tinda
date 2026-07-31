@extends('admin.layout')
@section('title', 'CTA Settings')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>CTA Settings</h2>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label fw-bold">CTA Badge Text</label>
                <input type="text" name="settings[cta_badge]" class="form-control" value="{{ App\Models\Setting::getValue('cta_badge', 'EXCLUSIVE REAL ESTATE DEALS') }}">
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">CTA Title</label>
                <input type="text" name="settings[cta_title]" class="form-control" value="{{ App\Models\Setting::getValue('cta_title', 'Looking for the Best Property Investment?') }}">
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">CTA Subtitle</label>
                <textarea name="settings[cta_subtitle]" class="form-control" rows="3">{{ App\Models\Setting::getValue('cta_subtitle', 'Get a free consultation with our experts and discover premium residential flats, townships, and commercial spaces with assured returns.') }}</textarea>
            </div>
            
            <div class="row mt-4 border-top pt-4">
                <h5 class="mb-3 text-primary"><i class="fa-solid fa-box me-2"></i> White Box Content</h5>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Box Title</label>
                    <input type="text" name="settings[cta_box_title]" class="form-control" value="{{ App\Models\Setting::getValue('cta_box_title', 'Speak to an Expert') }}">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Box Subtitle</label>
                    <input type="text" name="settings[cta_box_subtitle]" class="form-control" value="{{ App\Models\Setting::getValue('cta_box_subtitle', 'Book your VIP session today before prices increase.') }}">
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">WhatsApp Number (with country code)</label>
                    <input type="text" name="settings[cta_whatsapp]" class="form-control" value="{{ App\Models\Setting::getValue('cta_whatsapp', '919876543210') }}">
                    <div class="form-text">Example: 919876543210 (No + sign)</div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">WhatsApp Button Text</label>
                    <input type="text" name="settings[cta_wa_text]" class="form-control" value="{{ App\Models\Setting::getValue('cta_wa_text', 'Chat on WhatsApp') }}">
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Secondary Button Text</label>
                    <input type="text" name="settings[cta_btn_text]" class="form-control" value="{{ App\Models\Setting::getValue('cta_btn_text', 'Request a Call Back') }}">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Secondary Button Link</label>
                    <input type="text" name="settings[cta_btn_link]" class="form-control" value="{{ App\Models\Setting::getValue('cta_btn_link', route('page.show', 'contact')) }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3"><i class="fa-solid fa-save me-2"></i>Save Settings</button>
        </form>
    </div>
</div>
@endsection