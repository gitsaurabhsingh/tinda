<?php
$content = file_get_contents('resources/views/layouts/app.blade.php');

$start = strpos($content, '<script>
        document.addEventListener(\'DOMContentLoaded\', function() {
            const themeToggle = document.getElementById(\'themeToggle\');');

if ($start !== false) {
    $end = strpos($content, '</script>', $start) + 9;
    $content = substr($content, 0, $start) . substr($content, $end);
    file_put_contents('resources/views/layouts/app.blade.php', $content);
    echo "Removed duplicate theme toggle JS script.";
} else {
    echo "Could not find duplicate script to remove.";
}
