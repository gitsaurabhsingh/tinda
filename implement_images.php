<?php
$dir = __DIR__;

// 1. Database Migration
$migrationName = 'add_gallery_images_to_blogs_table';
exec("php artisan make:migration $migrationName --table=blogs", $output);

$migrations = glob($dir . '/database/migrations/*_add_gallery_images_to_blogs_table.php');
if (!empty($migrations)) {
    $migrationFile = $migrations[0];
    $content = file_get_contents($migrationFile);
    
    $upSearch = 'public function up(): void
    {
        Schema::table(\'blogs\', function (Blueprint $table) {
            //
        });
    }';
    
    $upReplace = 'public function up(): void
    {
        Schema::table(\'blogs\', function (Blueprint $table) {
            $table->json(\'gallery_images\')->nullable();
        });
    }';
    
    $downSearch = 'public function down(): void
    {
        Schema::table(\'blogs\', function (Blueprint $table) {
            //
        });
    }';
    
    $downReplace = 'public function down(): void
    {
        Schema::table(\'blogs\', function (Blueprint $table) {
            $table->dropColumn(\'gallery_images\');
        });
    }';
    
    $content = str_replace($upSearch, $upReplace, $content);
    $content = str_replace($downSearch, $downReplace, $content);
    file_put_contents($migrationFile, $content);
    
    exec("php artisan migrate");
}

// 2. Controller logic for images saving
$uploadLogic = <<<PHP
        \$gallery = [];
        if(\$request->hasFile('images')) {
            foreach(\$request->file('images') as \$file) {
                \$path = \$file->store('blogs/gallery', 'public');
                \$gallery[] = '/storage/' . \$path;
            }
        }
PHP;

// AdminBlogController
$adminController = $dir . '/app/Http/Controllers/Admin/AdminBlogController.php';
$adminCode = file_get_contents($adminController);
// Replace dummy image store with real gallery array insertion
$adminStoreSearch = <<<PHP
        \$imagePath = "https://picsum.photos/seed/".rand(100,999)."/800/400";
        Blog::create([
            'user_id' => Auth::id() ?? 1,
            'category_id' => \$request->category_id,
            'title' => \$request->title,
            'slug' => Str::slug(\$request->title) . '-' . rand(1000, 9999),
            'content' => \$request->content,
            'excerpt' => Str::limit(strip_tags(\$request->content), 100),
            'featured_image' => \$imagePath,
            'status' => 'approved'
        ]);
PHP;

$adminStoreReplace = <<<PHP
        \$request->validate([
            'title' => 'required',
            'content' => 'required',
            'images' => 'array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        
        \$gallery = [];
        if(\$request->hasFile('images')) {
            foreach(\$request->file('images') as \$file) {
                \$path = \$file->store('blogs/gallery', 'public');
                \$gallery[] = '/storage/' . \$path;
            }
        }
        
        Blog::create([
            'user_id' => Auth::id() ?? 1,
            'category_id' => \$request->category_id,
            'title' => \$request->title,
            'slug' => Str::slug(\$request->title) . '-' . rand(1000, 9999),
            'content' => \$request->content,
            'excerpt' => Str::limit(strip_tags(\$request->content), 100),
            'featured_image' => !empty(\$gallery) ? \$gallery[0] : "https://picsum.photos/seed/".rand(100,999)."/800/400",
            'gallery_images' => json_encode(\$gallery),
            'status' => 'approved'
        ]);
PHP;

if(str_contains($adminCode, '$imagePath = "https://picsum.photos/')) {
    $adminCode = str_replace($adminStoreSearch, $adminStoreReplace, $adminCode);
    file_put_contents($adminController, $adminCode);
}


// UserBlogController
$userController = $dir . '/app/Http/Controllers/UserBlogController.php';
$userCode = file_get_contents($userController);
$userStoreSearch = <<<PHP
    public function store(Request \$request) {
        // Dummy store logic for now
        return redirect()->route('dashboard')->with('success', 'Blog submitted for review.');
    }
PHP;

$userStoreReplace = <<<PHP
    public function store(Request \$request) {
        \$request->validate([
            'title' => 'required',
            'content' => 'required',
            'images' => 'array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        
        \$gallery = [];
        if(\$request->hasFile('images')) {
            foreach(\$request->file('images') as \$file) {
                \$path = \$file->store('blogs/gallery', 'public');
                \$gallery[] = '/storage/' . \$path;
            }
        }
        
        Blog::create([
            'user_id' => auth()->id() ?? 1,
            'category_id' => \$request->category_id,
            'title' => \$request->title,
            'slug' => \Illuminate\Support\Str::slug(\$request->title) . '-' . rand(1000, 9999),
            'content' => \$request->content,
            'excerpt' => \Illuminate\Support\Str::limit(strip_tags(\$request->content), 100),
            'featured_image' => !empty(\$gallery) ? \$gallery[0] : "https://picsum.photos/seed/".rand(100,999)."/800/400",
            'gallery_images' => json_encode(\$gallery),
            'status' => 'pending'
        ]);
        
        return redirect()->route('dashboard')->with('success', 'Blog submitted for review.');
    }
PHP;
if(str_contains($userCode, '// Dummy store logic for now')) {
    $userCode = str_replace($userStoreSearch, $userStoreReplace, $userCode);
    file_put_contents($userController, $userCode);
}


// 3. Frontend Form Updates
// Admin Form
$adminFormFile = $dir . '/resources/views/admin/blogs-create.blade.php';
$adminFormHtml = file_get_contents($adminFormFile);

$fileInput = '<label class="form-label fw-bold mt-2">Upload Images (Max 5)</label><input type="file" name="images[]" class="form-control mb-3" multiple accept="image/*" id="imageUpload" onchange="checkFiles(this)">';
$adminFormHtml = preg_replace('/<textarea id="myeditor"/', $fileInput . "\n" . '<textarea id="myeditor"', $adminFormHtml);
if (!str_contains($adminFormHtml, 'function checkFiles(input)')) {
    $adminFormHtml = str_replace(
        '</script>', 
        '</script><script>function checkFiles(input) { if(input.files.length > 5) { alert("You can only upload a maximum of 5 images."); input.value = ""; } }</script>', 
        $adminFormHtml
    );
}
file_put_contents($adminFormFile, $adminFormHtml);


// User Form
$userFormFile = $dir . '/resources/views/user/blogs/create.blade.php';
$userFormHtml = file_get_contents($userFormFile);

$oldUserInput = '<input type="file" name="image" class="form-control">';
$newUserInput = '<input type="file" name="images[]" class="form-control" multiple accept="image/*" id="userImageUpload" onchange="checkUserFiles(this)">
<small class="text-muted">You can select up to 5 images.</small>';

$userFormHtml = str_replace($oldUserInput, $newUserInput, $userFormHtml);
if (!str_contains($userFormHtml, 'function checkUserFiles(input)')) {
    $userFormHtml = str_replace(
        '</script>', 
        '</script><script>function checkUserFiles(input) { if(input.files.length > 5) { alert("You can only upload a maximum of 5 images."); input.value = ""; } }</script>', 
        $userFormHtml
    );
}
file_put_contents($userFormFile, $userFormHtml);


// 4. Update Blog Details Page to show Gallery
$detailFile = $dir . '/resources/views/pages/blog-detail.blade.php';
$detailHtml = file_get_contents($detailFile);

$galleryHtml = <<<HTML
            @php 
                \$gallery = \$blog->gallery_images ? json_decode(\$blog->gallery_images) : []; 
            @endphp
            @if(!empty(\$gallery) && count(\$gallery) > 0)
                <h4 class="fw-bold mt-5 mb-3">Gallery</h4>
                <div class="row g-3 mb-5">
                    @foreach(\$gallery as \$img)
                    <div class="col-md-6 col-lg-4">
                        <img src="{{ \$img }}" class="img-fluid rounded shadow-sm w-100" style="object-fit: cover; height: 200px;">
                    </div>
                    @endforeach
                </div>
            @endif
HTML;

$detailHtml = preg_replace('/<\/div>\s*<\/div>\s*<\/div>\s*<\/div>/', "</div>\n" . $galleryHtml . "\n</div>\n</div>\n</div>", $detailHtml);
file_put_contents($detailFile, $detailHtml);

echo "Multiple image upload logic implemented.";
