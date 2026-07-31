<?php
$files = [
    __DIR__ . '/resources/views/layouts/guest.blade.php',
    __DIR__ . '/resources/views/layouts/app.blade.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        // Remove @vite directive
        $content = preg_replace("/@vite\(\[.*?\]\)/s", "", $content);
        
        // Add Bootstrap 5 if not exists
        if (!str_contains($content, 'bootstrap.min.css')) {
            $bootstrap = <<<HTML
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
HTML;
            $content = str_replace('</head>', $bootstrap . "\n</head>", $content);
        }
        
        file_put_contents($file, $content);
    }
}
echo "Vite removed and Bootstrap added to Breeze layouts.";
