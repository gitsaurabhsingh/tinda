<?php
$content = file_get_contents('resources/views/welcome.blade.php');

$content = str_replace(
    '<h4 class="fw-bold text-dark mb-2">Speak to an Expert</h4>',
    '<h4 class="fw-bold text-dark mb-2">{{ App\Models\Setting::getValue(\'cta_box_title\', \'Speak to an Expert\') }}</h4>',
    $content
);

$content = str_replace(
    '<p class="text-muted small mb-4">Book your VIP session today before prices increase.</p>',
    '<p class="text-muted small mb-4">{{ App\Models\Setting::getValue(\'cta_box_subtitle\', \'Book your VIP session today before prices increase.\') }}</p>',
    $content
);

$content = str_replace(
    "href=\"{{ App\Models\Setting::getValue('cta_btn_link', '#') }}\"",
    "href=\"{{ App\Models\Setting::getValue('cta_btn_link', route('page.show', 'contact')) }}\"",
    $content
);

file_put_contents('resources/views/welcome.blade.php', $content);
echo "Updated welcome.blade.php with box settings and link default.";
