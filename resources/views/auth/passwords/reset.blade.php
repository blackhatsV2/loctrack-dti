@extends('layouts.app')

@section('content')
<div class="glass-card animate-fade-in" style="max-width: 450px; margin: 0 auto;">
    <h2 style="text-align: center; margin-bottom: 2rem;">Set New Password</h2>
    <p style="color: var(--text-muted); text-align: center; margin-bottom: 2rem;">
        Enter the 6-digit code sent to your email and choose your new password.
    </p>

    @if (session('status'))
        <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #10b981; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; text-align: center;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.reset.update') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Verification Code</label>
            <input type="text" name="code" required maxlength="6" style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; background: rgba(0,0,0,0.2); border: 1px solid var(--glass-border); color: white; text-align: center; font-size: 1.5rem; letter-spacing: 5px;">
            @error('code') <small style="color: #f43f5e; margin-top: 0.25rem; display: block;">{{ $message }}</small> @enderror
        </div>

        <div style="margin-bottom: 1.5rem; position: relative;">
            <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">New Password</label>
            <input type="password" id="password" name="password" required style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; background: rgba(0,0,0,0.2); border: 1px solid var(--glass-border); color: white; padding-right: 2.5rem;">
            <button type="button" onclick="togglePassword('password')" style="position: absolute; right: 0.75rem; bottom: 0.75rem; background: transparent; border: none; color: var(--text-muted); cursor: pointer; padding: 0;">
                <span id="password-toggle-icon">👁️</span>
            </button>
            @error('password') <small style="color: #f43f5e; margin-top: 0.25rem; display: block;">{{ $message }}</small> @enderror
        </div>

        <div style="margin-bottom: 2rem; position: relative;">
            <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; background: rgba(0,0,0,0.2); border: 1px solid var(--glass-border); color: white; padding-right: 2.5rem;">
            <button type="button" onclick="togglePassword('password_confirmation')" style="position: absolute; right: 0.75rem; bottom: 0.75rem; background: transparent; border: none; color: var(--text-muted); cursor: pointer; padding: 0;">
                <span id="password_confirmation-toggle-icon">👁️</span>
            </button>
        </div>

        <button type="submit" style="width: 100%; position: relative;" id="reset-btn">
            <span id="btn-text">Reset Password</span>
            <div id="btn-spinner" class="spinner" style="display: none; width: 20px; height: 20px; border-width: 2px; position: absolute; left: 50%; top: 50%; margin: -10px 0 0 -10px; border-top-color: white;"></div>
        </button>
    </form>
</div>

@section('scripts')
<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = document.getElementById(id + '-toggle-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerText = '🙈';
        } else {
            input.type = 'password';
            icon.innerText = '👁️';
        }
    }

    document.querySelector('form').addEventListener('submit', function() {
        const btn = document.getElementById('reset-btn');
        const text = document.getElementById('btn-text');
        const spinner = document.getElementById('btn-spinner');
        
        btn.disabled = true;
        text.style.visibility = 'hidden';
        spinner.style.display = 'block';
    });
</script>
@endsection
@endsection
