<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your OTP Code</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f7f6; color: #333; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <div style="background-color: #0f2a4a; padding: 20px; text-align: center;">
            <h2 style="color: #fff; margin: 0;">Welcome to {{ config('app.name', 'Tindablog') }}</h2>
        </div>
        <div style="padding: 30px; text-align: center;">
            <h3 style="margin-top: 0;">Your Verification Code</h3>
            <p style="font-size: 16px; line-height: 1.5; color: #555;">Please use the following 6-digit code to securely log in to your account. This code is valid for 10 minutes.</p>
            <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; font-size: 32px; font-weight: bold; letter-spacing: 5px; padding: 15px; margin: 25px 0; border-radius: 8px; display: inline-block;">
                {{ $otp }}
            </div>
            <p style="font-size: 14px; color: #888;">If you didn't request this code, you can safely ignore this email.</p>
        </div>
        <div style="background-color: #f9fafb; padding: 15px; text-align: center; border-top: 1px solid #eee;">
            <p style="margin: 0; font-size: 12px; color: #aaa;">&copy; {{ date('Y') }} {{ config('app.name', 'Tindablog') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
