<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'seo_title', 'seo_description'];
    public function blogs() { return $this->belongsToMany(Blog::class); }
}