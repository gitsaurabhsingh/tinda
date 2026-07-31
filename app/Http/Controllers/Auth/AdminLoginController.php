<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminLoginController extends Controller
{
    /**
     * Display the admin login view.
     */
    public function create(): View
    {
        return view('admin.login');
    }

    /**
     * Handle an incoming admin authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::guard('admin')->user();
            
            if (!$user->is_admin) {
                Auth::guard('admin')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors([
                    'email' => 'Access denied. You do not have administrator privileges.',
                ]);
            }

            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }

        return back()->withErrors([
            'email' => trans('auth.failed'),
        ])->onlyInput('email');
    }

    /**
     * Destroy an authenticated admin session.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
