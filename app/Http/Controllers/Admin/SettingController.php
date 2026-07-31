<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
        
    public function cta()
    {
        return view('admin.settings.cta');
    }

    public function header()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        $pages = \App\Models\Page::all();
        return view('admin.settings-header', compact('settings', 'pages'));
    }

    public function hero()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings-hero', compact('settings'));
    }
    
    public function footer()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings-footer', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token', '_method', 'hero_image_file', 'header_logo_file', 'footer_logo_file');
        
        // Handle file upload for hero image
        if ($request->hasFile('header_logo_file')) {
            $path = \App\Helpers\ImageHelper::uploadAndConvertToWebp($request->file('header_logo_file'), 'settings');
            $data['site_logo'] = '/storage/' . $path;
        }

        if ($request->hasFile('hero_image_file')) {
            $path = \App\Helpers\ImageHelper::uploadAndConvertToWebp($request->file('hero_image_file'), 'settings');
            $data['hero_image'] = '/storage/' . $path;
        }

        if ($request->hasFile('footer_logo_file')) {
            $path = \App\Helpers\ImageHelper::uploadAndConvertToWebp($request->file('footer_logo_file'), 'settings');
            $data['footer_logo'] = '/storage/' . $path;
        }

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}