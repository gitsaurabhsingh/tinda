<?php
$content = file_get_contents('resources/views/welcome.blade.php');

$startMarker = '<!-- Newsletter Subscription Banner -->';
$endMarker = '<!-- Newsletter end -->'; 

// Let me check if the end marker exists, otherwise I'll find where footer starts.
// Actually, earlier the newsletter was before the footer or inside it. Let's find it.
$start = strpos($content, $startMarker);
if ($start !== false) {
    // Find the next section, which might be Footer or @endsection
    $end = strpos($content, '@endsection', $start);
    if ($end !== false) {
        // Let's replace from $start to $end with our new CTA
        
        $newCTA = <<<'EOT'
<!-- Premium Real Estate CTA Section -->
<div class="container-fluid px-4 px-xl-5 my-5">
    <div class="card border-0 shadow-lg position-relative overflow-hidden" style="border-radius: 24px; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
        <!-- Decorative Background Elements -->
        <div class="position-absolute" style="top: -50%; left: -10%; width: 50%; height: 200%; background: radial-gradient(circle, rgba(212,175,55,0.15) 0%, rgba(212,175,55,0) 70%); transform: rotate(30deg); pointer-events: none;"></div>
        <div class="position-absolute" style="bottom: -50%; right: -10%; width: 40%; height: 200%; background: radial-gradient(circle, rgba(212,175,55,0.1) 0%, rgba(212,175,55,0) 70%); transform: rotate(-30deg); pointer-events: none;"></div>
        
        <div class="card-body p-5 position-relative z-index-1">
            <div class="row align-items-center">
                <div class="col-lg-7 mb-4 mb-lg-0 text-center text-lg-start">
                    <span class="badge rounded-pill mb-3 px-3 py-2" style="background: rgba(212,175,55,0.2); color: #d4af37; border: 1px solid rgba(212,175,55,0.5); font-weight: 600; letter-spacing: 1px;">EXCLUSIVE REAL ESTATE DEALS</span>
                    <h2 class="fw-bolder text-white mb-3" style="font-size: 2.5rem; line-height: 1.2;">Looking for the Best Property Investment?</h2>
                    <p class="text-white-50 fs-5 mb-4" style="max-width: 600px;">Get a free consultation with our experts and discover premium residential flats, townships, and commercial spaces with assured returns.</p>
                    
                    <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                        <div class="d-flex align-items-center text-white-50" style="font-size: 0.9rem;">
                            <i class="fa-solid fa-check-circle me-2" style="color: #d4af37;"></i> 100% Free Consultation
                        </div>
                        <div class="d-flex align-items-center text-white-50" style="font-size: 0.9rem;">
                            <i class="fa-solid fa-check-circle me-2" style="color: #d4af37;"></i> Verified Properties
                        </div>
                        <div class="d-flex align-items-center text-white-50" style="font-size: 0.9rem;">
                            <i class="fa-solid fa-check-circle me-2" style="color: #d4af37;"></i> High ROI Guaranteed
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-5 text-center text-lg-end">
                    <div class="bg-white p-4 rounded-4 shadow d-inline-block text-center w-100" style="max-width: 400px;">
                        <h4 class="fw-bold text-dark mb-2">Speak to an Expert</h4>
                        <p class="text-muted small mb-4">Book your VIP session today before prices increase.</p>
                        
                        <a href="https://wa.me/919876543210" target="_blank" class="btn w-100 py-3 fw-bold shadow-sm mb-3 d-flex align-items-center justify-content-center gap-2" style="background: #25D366; color: white; border-radius: 12px; font-size: 1.1rem; transition: transform 0.2s;">
                            <i class="fa-brands fa-whatsapp fs-4"></i> Chat on WhatsApp
                        </a>
                        
                        <a href="#" class="btn w-100 py-3 fw-bold text-dark d-flex align-items-center justify-content-center gap-2" style="background: linear-gradient(45deg, #d4af37, #f3e5ab); border: none; border-radius: 12px; font-size: 1.1rem; transition: transform 0.2s; box-shadow: 0 4px 15px rgba(212,175,55,0.3);">
                            <i class="fa-solid fa-calendar-check"></i> Request a Call Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

EOT;
        $content = substr($content, 0, $start) . $newCTA . "\n" . substr($content, $end);
        file_put_contents('resources/views/welcome.blade.php', $content);
        echo "Replaced Newsletter with Profitable CTA.";
    }
}
