<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

$page = \App\Models\Page::firstOrCreate(
    ['slug' => 'advertise-with-us'],
    [
        'title' => 'Advertise with Us',
        'content' => '
            <h2>Partner With Us</h2>
            <p>Reach a highly engaged audience of readers who are passionate about learning and discovering new things. We offer a variety of advertising opportunities designed to help you meet your marketing goals.</p>
            
            <h3>Our Reach</h3>
            <ul>
                <li><strong>Monthly Active Users:</strong> 50,000+</li>
                <li><strong>Newsletter Subscribers:</strong> 15,000+</li>
                <li><strong>Social Media Reach:</strong> 100,000+</li>
            </ul>

            <h3>Advertising Options</h3>
            <p>We provide multiple ways for you to get your message in front of our audience:</p>
            <ul>
                <li><strong>Banner Ads:</strong> Prominent placement on our homepage and article pages.</li>
                <li><strong>Sponsored Content:</strong> High-quality, tailored articles written in collaboration with our editorial team.</li>
                <li><strong>Newsletter Sponsorship:</strong> Reach our dedicated subscribers directly in their inbox.</li>
            </ul>
            
            <h3>Get in Touch</h3>
            <p>Ready to start your campaign? Contact our advertising team at <strong>advertising@tindablog.com</strong> or use our <a href="/contact">Contact Page</a> to request our full media kit and pricing.</p>
        ',
        'meta_description' => 'Discover advertising opportunities with Tindablog and reach a passionate audience.',
        'image' => 'https://images.unsplash.com/photo-1542744094-24638ea0bc40?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80', // Dynamic marketing/advertising image
        'status' => 'published'
    ]
);

echo "Advertise with Us page created/updated successfully at /advertise-with-us\n";
