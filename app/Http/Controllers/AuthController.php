<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\DisasterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $loginInput = $request->input('email');
        $password = $request->input('password');

        // Determine if input is email or name
        if (filter_var($loginInput, FILTER_VALIDATE_EMAIL)) {
            $credentials = ['email' => $loginInput, 'password' => $password];
        } else {
            // It's treated as a name. Must have at least one space.
            if (!str_contains($loginInput, ' ')) {
                return back()->withErrors([
                    'email' => 'User not found. Please use "Firstname Lastname" format.',
                ])->onlyInput('email');
            }

            // Attempt to find the user by name to get their email
            // We check for exact match, like match, or reversed "Lastname, Firstname" format
            $user = User::where('name', $loginInput)
                ->orWhere('name', 'like', '%' . $loginInput . '%')
                ->first();

            if (!$user) {
                // Try to match "Lastname, Firstname" format if input was "Firstname Lastname"
                $parts = explode(' ', $loginInput);
                $first = $parts[0];
                $last = end($parts);
                $user = User::where('name', 'like', "$last%, %$first%")->first();
            }

            if (!$user) {
                return back()->withErrors([
                    'email' => 'User not found.',
                ])->onlyInput('email');
            }

            $credentials = ['email' => $user->email, 'password' => $password];
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Pre-warm hazard caches if not already present, to speed up map load after login
            if (!Cache::has('usgs_earthquakes') || !Cache::has('nasa_events')) {
                try {
                    $disasterService = app(DisasterService::class);
                    $disasterService->getCachedEarthquakes(true);
                    $disasterService->getCachedNaturalEvents(true);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Pre-warming hazard caches failed: ' . $e->getMessage());
                }
            }

            // Redirect based on role
            if (Auth::user()->is_admin) {
                return redirect()->intended('admin/dashboard');
            }

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
