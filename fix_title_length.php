<?php
$adminFile = 'app/Http/Controllers/Admin/AdminBlogController.php';
$userFile = 'app/Http/Controllers/UserBlogController.php';

// Fix AdminBlogController
if (file_exists($adminFile)) {
    $admin = file_get_contents($adminFile);
    $admin = str_replace(
        "'title' => 'required|unique:blogs,title',", 
        "'title' => 'required|max:250|unique:blogs,title',", 
        $admin
    );
    $admin = str_replace(
        "'title' => 'required|unique:blogs,title,' . \$id,", 
        "'title' => 'required|max:250|unique:blogs,title,' . \$id,", 
        $admin
    );
    file_put_contents($adminFile, $admin);
    echo "Updated AdminBlogController\n";
}

// Fix UserBlogController
if (file_exists($userFile)) {
    $user = file_get_contents($userFile);
    $user = str_replace(
        "'title' => 'required|unique:blogs,title',", 
        "'title' => 'required|max:250|unique:blogs,title',", 
        $user
    );
    $user = str_replace(
        "'title' => 'required|unique:blogs,title,' . \$id,", 
        "'title' => 'required|max:250|unique:blogs,title,' . \$id,", 
        $user
    );
    file_put_contents($userFile, $user);
    echo "Updated UserBlogController\n";
}
