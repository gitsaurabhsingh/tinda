<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$privacy = \App\Models\Page::where('slug', 'privacy-policy')->first();
if ($privacy) {
    $privacy->image = 'https://images.unsplash.com/photo-1550592704-6c76defa99ce?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80';
    $privacy->save();
}

$terms = \App\Models\Page::where('slug', 'terms-of-service')->first();
if ($terms) {
    $terms->image = 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80';
    $terms->save();
}

echo "Images added to pages!\n";
