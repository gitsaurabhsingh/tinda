<?php
// AdminBlogController
$admin = file_get_contents('app/Http/Controllers/Admin/AdminBlogController.php');
$admin = str_replace(
    "'title' => 'required',", 
    "'title' => 'required|unique:blogs,title',", 
    $admin
);
// Fix the update method in AdminBlogController which needs the ID exception
$admin = preg_replace(
    "/'title' => 'required\|unique:blogs,title',(\s+'content')/", 
    "'title' => 'required|unique:blogs,title,' . \$id,$1", 
    $admin, 1 // Only replace the second occurrence (or wait, str_replace replaces both, so the second one is for update)
);

// Actually, let's just do it manually with preg_replace
$admin = file_get_contents('app/Http/Controllers/Admin/AdminBlogController.php');
$admin = preg_replace('/(public function store.*?\[\s*)\'title\' => \'required\'/s', '$1\'title\' => \'required|unique:blogs,title\'', $admin);
$admin = preg_replace('/(public function update.*?\[\s*)\'title\' => \'required\'/s', '$1\'title\' => \'required|unique:blogs,title,\' . $id', $admin);
file_put_contents('app/Http/Controllers/Admin/AdminBlogController.php', $admin);

// UserBlogController
$user = file_get_contents('app/Http/Controllers/UserBlogController.php');
$user = preg_replace('/(public function store.*?\[\s*)\'title\' => \'required\'/s', '$1\'title\' => \'required|unique:blogs,title\'', $user);
$user = preg_replace('/(public function update.*?\[\s*)\'title\' => \'required\'/s', '$1\'title\' => \'required|unique:blogs,title,\' . $id', $user);
file_put_contents('app/Http/Controllers/UserBlogController.php', $user);

echo "Updated controllers for unique title validation.\n";
