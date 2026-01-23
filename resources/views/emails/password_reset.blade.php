<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .container { border: 1px solid #ddd; border-radius: 10px; padding: 30px; background-color: #f9f9f9; }
        .otp-code { font-size: 32px; font-weight: bold; letter-spacing: 5px; text-align: center; color: #E74C3C; background: #fff; padding: 20px; border-radius: 5px; border: 1px dashed #E74C3C; margin: 20px 0; }
        .footer { margin-top: 30px; font-size: 12px; color: #777; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Your Password</h2>
        <p>You requested a password reset. Please use the following One-Time Password (OTP) to reset your password. This code is valid for 10 minutes.</p>
        <div class="otp-code">{{ $otp }}</div>
        <p>If you did not request this, please ignore this email.</p>
        <div class="footer">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</div>
    </div>
</body>
</html>
