<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscriber;

class AdminSubscriberController extends Controller
{
    public function index()
    {
        $subscribers = Subscriber::latest()->paginate(20);
        return view('admin.subscribers', compact('subscribers'));
    }

    public function destroy($id)
    {
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete();
        
        return back()->with('success', 'Subscriber deleted successfully.');
    }
}
