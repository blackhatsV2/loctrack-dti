@extends('layouts.app')

@section('content')
<div class="animate-fade-in text-center" style="max-width: 800px; margin: 0 auto;">
    <h1 style="font-size: 3.5rem; margin-bottom: 1.5rem; font-weight: 600; line-height: 1.1;">
        Track Your Team in <br>
        <span style="background: linear-gradient(to right, #818cf8, #c084fc); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Real-Time</span>
    </h1>
    <p style="color: var(--text-muted); font-size: 1.25rem; margin-bottom: 3rem;">
        The most elegant and reliable way to coordinate your workforce. <br>
        Glassmorphic interface, Leaflet maps, and seamless tracking.
    </p>

    <div style="display: flex; gap: 1.5rem; justify-content: center;">
        <a href="{{ route('register') }}" class="btn" style="padding: 1rem 2.5rem;">Get Started</a>
        <a href="{{ route('login') }}" class="btn" style="background: var(--glass); border: 1px solid var(--glass-border); padding: 1rem 2.5rem;">Sign In</a>
    </div>

    <div style="margin-top: 6rem; position: relative;">
        <div style="background: var(--glass); padding: 1rem; border-radius: 2rem; border: 1px solid var(--glass-border); opacity: 0.5;">
            <div style="height: 300px; background: rgba(0,0,0,0.3); border-radius: 1.5rem; display: flex; align-items: center; justify-content: center;">
                 <span style="color: var(--text-muted);">Map Preview Placeholder</span>
            </div>
        </div>
    </div>
</div>

<style>
    .text-center { text-align: center; }
</style>
@endsection
