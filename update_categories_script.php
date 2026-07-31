<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

$blog = \App\Models\Blog::where('title', 'like', '%Gaur City 12th Avenue%')->first();
$sport = \App\Models\Category::where('name', 'Sport')->orWhere('name', 'SPORT')->orWhere('name', 'Sports')->first();

if ($blog && $sport) {
    $blog->categories()->syncWithoutDetaching([$sport->id]);
    echo "Added " . $sport->name . " category to blog: " . $blog->title . "\n";
} else {
    echo "Could not find blog or sport category.\n";
    if (!$blog) echo "Blog not found.\n";
    if (!$sport) echo "Sport category not found.\n";
}
