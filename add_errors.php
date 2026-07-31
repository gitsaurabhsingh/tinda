<?php
$files = [
    'resources/views/admin/blogs-create.blade.php',
    'resources/views/admin/blogs-edit.blade.php',
    'resources/views/user/blogs/create.blade.php',
    'resources/views/user/blogs/edit.blade.php'
];
foreach($files as $file) {
    if(file_exists($file)) {
        $content = file_get_contents($file);
        if(strpos($content, '@error(\'title\')') === false) {
            // Find the title input and add the error block after it
            $content = preg_replace('/(<input[^>]*name="title"[^>]*>)/i', "$1\n                                @error('title')\n                                    <div class=\"text-danger mt-1 small\"><i class=\"fa-solid fa-circle-exclamation me-1\"></i> {{ \$message }}</div>\n                                @enderror", $content);
            file_put_contents($file, $content);
            echo "Added error reporting to $file\n";
        }
    }
}
