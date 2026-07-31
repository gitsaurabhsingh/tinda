<?php
$files = [
    'resources/views/pages/contact.blade.php',
    'resources/views/pages/page.blade.php',
    'resources/views/layouts/app.blade.php',
    'resources/views/admin/login.blade.php',
    'resources/views/admin/layout.blade.php',
    'resources/views/auth/register.blade.php',
    'resources/views/auth/login.blade.php',
    'resources/views/auth/forgot-password.blade.php',
];
foreach($files as $file) {
    if(file_exists($file)) {
        $content = file_get_contents($file);
        $content = str_replace('href="/"', 'href="{{ url(\'/\') }}"', $content);
        file_put_contents($file, $content);
        echo 'Updated ' . $file . PHP_EOL;
    }
}
echo "Done!\n";
