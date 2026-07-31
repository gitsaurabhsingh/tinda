<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->first();
        
        if (!$page) {
            return app(\App\Http\Controllers\BlogController::class)->show($slug);
        }
        
        // Special template for contact page
        if (in_array($slug, ['contact-us', 'contact']) || str_contains($slug, 'contact')) {
            return view('pages.contact', compact('page'));
        }
        
        return view('pages.page', compact('page'));
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $message = ContactMessage::create($request->all());

        try {
            Mail::to(env('MAIL_FROM_ADDRESS'))->send(new \App\Mail\NewContactEnquiry($request->all()));
        } catch (\Exception $e) {
            Log::error('Mail error: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Your message has been sent successfully. We will get back to you soon!');
    }
}
