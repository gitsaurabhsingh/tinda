<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Validator;

class SubscriberController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:subscribers,email',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Subscriber::create([
            'email' => $request->email,
            'status' => 'active',
        ]);

        return back()->with('success', 'Successfully subscribed to the newsletter!');
    }
}
