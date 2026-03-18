<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\VerificationCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * Show the form for requesting a verification code.
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Send a verification code to the user's email.
     */
    public function sendResetCodeEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $email = $request->email;
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store code in password_reset_tokens table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => $code, // Store the numeric code as the token
                'created_at' => now()
            ]
        );

        // Send email
        Mail::to($email)->send(new VerificationCodeMail($code));

        return redirect()->route('password.reset.form', ['email' => $email])
            ->with('status', 'A verification code has been sent to your email.');
    }

    /**
     * Show the form for resetting the password.
     */
    public function showResetForm(Request $request)
    {
        return view('auth.passwords.reset', [
            'email' => $request->email
        ]);
    }

    /**
     * Reset the user's password.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|string|size:6',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->code)
            ->first();

        if (!$record || now()->diffInMinutes(\Illuminate\Support\Carbon::parse($record->created_at)) > 60) {
            return back()->withErrors(['code' => 'Invalid or expired verification code.']);
        }

        $user = User::where('email', $request->email)->first();
        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        // Delete the token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Log the user in
        Auth::login($user);

        return redirect()->route('dashboard')->with('status', 'Your password has been reset successfully.');
    }
}
