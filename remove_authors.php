<?php
$content = file_get_contents('resources/views/welcome.blade.php');

$start = strpos($content, '<!-- Top Authors Section -->');
$end = strpos($content, '<!-- Newsletter Subscription Banner -->');

if ($start !== false && $end !== false) {
    $content = substr($content, 0, $start) . substr($content, $end);
    file_put_contents('resources/views/welcome.blade.php', $content);
    echo 'Removed Top Authors section.';
} else {
    echo 'Could not find section markers.';
}
