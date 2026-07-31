<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Blog;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password')
        ]);

        $cat = Category::create([
            'name' => 'Technology',
            'slug' => 'technology',
            'description' => 'Tech news and guides'
        ]);

        for ($i = 1; $i <= 6; $i++) {
            Blog::create([
                'user_id' => $user->id,
                'category_id' => $cat->id,
                'title' => "Dynamic Blog Title {$i}",
                'slug' => "dynamic-blog-title-{$i}",
                'content' => "<p>This is the full rich text content for blog {$i}. It will be dynamic.</p>",
                'excerpt' => "This is a short excerpt for blog {$i} to show on the card...",
                'featured_image' => "https://picsum.photos/seed/{$i}0/400/250",
                'status' => 'approved'
            ]);
        }

        Setting::insert([
            ['key' => 'site_name', 'value' => 'Tindablog Dynamic'],
            ['key' => 'footer_text', 'value' => 'This footer is managed dynamically from the admin database!'],
            ['key' => 'hero_title', 'value' => 'Dynamic Hero Banner'],
            ['key' => 'hero_subtitle', 'value' => 'This banner text comes from the DB settings.']
        ]);
    }
}