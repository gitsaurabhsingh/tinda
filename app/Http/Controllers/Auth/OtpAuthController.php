<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;

class OtpAuthController extends Controller
{
    /**
     * Send OTP for Login
     */
    public function sendLoginOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'No account found with this email. Please register first.'
        ]);

        $user = User::where('email', $request->email)->first();
        
        // Prevent Admin from logging in via OTP if preferred (Optional check)
        // if ($user->is_admin) {
        //     return response()->json(['success' => false, 'message' => 'Admins must use the password login page.']);
        // }

        return $this->generateAndSendOtp($user);
    }

    /**
     * Send OTP for Registration
     */
    public function sendRegisterOtp(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ], [
            'email.unique' => 'An account with this email already exists. Please log in.'
        ]);

        // Create new user with a random password since they will use OTP
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make(Str::random(24)),
        ]);

        return $this->generateAndSendOtp($user);
    }

    /**
     * Verify OTP and Login
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|numeric|digits:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->otp !== $request->otp) {
            return response()->json(['success' => false, 'message' => 'Invalid OTP code. Please try again.']);
        }

        if (Carbon::now()->isAfter($user->otp_expires_at)) {
            return response()->json(['success' => false, 'message' => 'The OTP code has expired. Please request a new one.']);
        }

        // OTP is valid
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        Auth::login($user, true); // Log the user in and remember them

        return response()->json(['success' => true, 'message' => 'Login successful!', 'redirect' => route('dashboard')]);
    }

    /**
     * Helper to generate and send OTP
     */
    private function generateAndSendOtp(User $user)
    {
        $otp = rand(100000, 999999);
        
        $user->otp = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(1);
        $user->save();

        try {
            Mail::to($user->email)->send(new SendOtpMail($otp));
            return response()->json(['success' => true, 'message' => 'OTP sent successfully to your email.']);
        } catch (\Exception $e) {
            // Revert OTP if email fails
            $user->otp = null;
            $user->otp_expires_at = null;
            $user->save();
            return response()->json(['success' => false, 'message' => 'Failed to send OTP email. Please try again later.']);
        }
    }
}
