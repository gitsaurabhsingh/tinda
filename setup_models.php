<?php
$modelsDir = __DIR__ . '/app/Models/';

$userModel = <<<PHP
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected \$fillable = ['name', 'email', 'password', 'bio', 'social_links', 'avatar'];
    protected \$hidden = ['password', 'remember_token'];
    protected \$casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'social_links' => 'array',
    ];

    public function blogs() { return \$this->hasMany(Blog::class); }
    public function comments() { return \$this->hasMany(Comment::class); }
}
PHP;
file_put_contents($modelsDir . 'User.php', $userModel);

$blogModel = <<<PHP
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected \$fillable = [
        'user_id', 'category_id', 'title', 'slug', 'content', 'excerpt', 
        'featured_image', 'status', 'views', 'reading_time', 'is_featured', 
        'is_trending', 'seo_title', 'seo_description'
    ];

    public function user() { return \$this->belongsTo(User::class); }
    public function category() { return \$this->belongsTo(Category::class); }
    public function comments() { return \$this->hasMany(Comment::class); }
    public function tags() { return \$this->belongsToMany(Tag::class); }
}
PHP;
file_put_contents($modelsDir . 'Blog.php', $blogModel);

$categoryModel = <<<PHP
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected \$fillable = ['name', 'slug', 'description', 'seo_title', 'seo_description'];
    public function blogs() { return \$this->hasMany(Blog::class); }
}
PHP;
file_put_contents($modelsDir . 'Category.php', $categoryModel);

$commentModel = <<<PHP
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected \$fillable = ['user_id', 'blog_id', 'parent_id', 'content', 'status'];
    public function user() { return \$this->belongsTo(User::class); }
    public function blog() { return \$this->belongsTo(Blog::class); }
    public function replies() { return \$this->hasMany(Comment::class, 'parent_id'); }
}
PHP;
file_put_contents($modelsDir . 'Comment.php', $commentModel);

$tagModel = <<<PHP
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected \$fillable = ['name', 'slug'];
    public function blogs() { return \$this->belongsToMany(Blog::class); }
}
PHP;
file_put_contents($modelsDir . 'Tag.php', $tagModel);

echo "Models updated successfully.";
