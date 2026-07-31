<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

\App\Models\Page::firstOrCreate(
    ['slug' => 'privacy-policy'],
    [
        'title' => 'Privacy Policy', 
        'content' => '<h2>Privacy Policy</h2><p>This is a placeholder for your Privacy Policy. You can edit this content from your Admin Panel.</p>', 
        'status' => 'published'
    ]
);

\App\Models\Page::firstOrCreate(
    ['slug' => 'terms-of-service'],
    [
        'title' => 'Terms of Service', 
        'content' => '<h2>Terms of Service</h2><p>This is a placeholder for your Terms of Service. You can edit this content from your Admin Panel.</p>', 
        'status' => 'published'
    ]
);

echo "Pages created!\n";
