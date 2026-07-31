<?php
$dir = __DIR__;
require $dir . '/vendor/autoload.php';
$app = require_once $dir . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Delete dummy blogs
$deleted = \App\Models\Blog::where('title', 'like', 'Dynamic Blog Title%')->delete();
echo "Deleted " . $deleted . " dummy blogs.";
