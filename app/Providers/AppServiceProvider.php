<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // View Composer for Settings
        View::composer('*', function ($view) {
            $settings = [];
            if (Schema::hasTable('settings')) {
                $settingsDb = Setting::all();
                foreach ($settingsDb as $setting) {
                    $settings[$setting->key] = $setting->value;
                }
            }
            // Defaults
            if (empty($settings['site_name'])) $settings['site_name'] = 'Tindablog';
            if (empty($settings['footer_text'])) $settings['footer_text'] = 'Premium modern blogging platform built with Laravel 12.';
            if (empty($settings['hero_title'])) $settings['hero_title'] = 'Welcome to Tindablog';
            if (empty($settings['hero_subtitle'])) $settings['hero_subtitle'] = 'Discover premium articles on technology, lifestyle, and business.';
            
            $view->with('settings', $settings);

            // Unread Messages Count (For Admin Panel)
            if (Schema::hasTable('contact_messages')) {
                $unreadMessages = \App\Models\ContactMessage::where('is_read', false)->count();
                $view->with('unreadMessages', $unreadMessages);
            } else {
                $view->with('unreadMessages', 0);
            }
        });
    }
}