<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class AdminContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(15);
        return view('admin.contacts.index', compact('messages'));
    }

    public function markAsRead($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->update(['is_read' => true]);
        
        return redirect()->back()->with('success', 'Message marked as read.');
    }

    public function destroy($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();
        
        return redirect()->back()->with('success', 'Message deleted successfully.');
    }
}
