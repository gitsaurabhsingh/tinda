<?php
$welcome = file_get_contents('resources/views/welcome.blade.php');
$welcome = str_replace('Setting::get(', 'Setting::getValue(', $welcome);
file_put_contents('resources/views/welcome.blade.php', $welcome);

$cta = file_get_contents('resources/views/admin/settings/cta.blade.php');
$cta = str_replace('Setting::get(', 'Setting::getValue(', $cta);
file_put_contents('resources/views/admin/settings/cta.blade.php', $cta);

echo "Fixed Setting::get to Setting::getValue\n";
