<x-mail::message>
# Verification Code

Hello,

You are receiving this email because we received a password reset or registration request for your account.

Your verification code is:

<h1 style="text-align: center; letter-spacing: 5px; color: #6366f1;">{{ $code }}</h1>

This code will expire in 60 minutes.

If you did not request this, no further action is required.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
