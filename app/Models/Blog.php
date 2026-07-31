<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'user_id', 'title', 'slug', 'content', 'excerpt', 
        'featured_image', 'status', 'views', 'reading_time', 'is_featured', 
        'is_trending', 'seo_title', 'seo_description', 'gallery_images'
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function categories() { return $this->belongsToMany(Category::class); }
    public function comments() { return $this->hasMany(Comment::class); }
    public function tags() { return $this->belongsToMany(Tag::class); }
}