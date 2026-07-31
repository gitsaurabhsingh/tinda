<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;

class AdminUserController extends Controller {
    public function index() {
        $users = User::all();
        return view('admin.users', compact('users'));
    }
    public function destroy($id) {
        User::findOrFail($id)->delete();
        return back()->with('success', 'User deleted.');
    }
}