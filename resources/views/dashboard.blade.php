@extends('layouts.app')

@section('content')
<div class="glass-card animate-fade-in text-center">
    <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">Welcome, {{ Auth::user()->name }}</h1>
    <p style="color: var(--text-muted); margin-bottom: 2.5rem;">Your location is currently being tracked securely to improve team coordination.</p>
    
    <div id="status-container" style="background: rgba(0,0,0,0.2); border-radius: 1rem; padding: 2rem; margin-bottom: 2rem;">
        <div id="tracking-status" style="font-size: 1.25rem; font-weight: 600; color: #4ade80;">
            <span class="pulse"></span> Active Tracking
        </div>
        <div id="live-coords" style="margin-top: 1rem; font-family: monospace; color: var(--text-muted);">
            Waiting for coordinates...
        </div>
    </div>

    <button id="toggle-tracking" class="btn">Pause Tracking</button>
</div>

<style>
    .pulse {
        display: inline-block;
        width: 12px;
        height: 12px;
        background: #4ade80;
        border-radius: 50%;
        margin-right: 0.5rem;
        box-shadow: 0 0 0 rgba(74, 222, 128, 0.4);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(74, 222, 128, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(74, 222, 128, 0); }
        100% { box-shadow: 0 0 0 0 rgba(74, 222, 128, 0); }
    }

    .text-center { text-align: center; }
</style>
@endsection

@section('scripts')
<script>
    let isTracking = true;
    let watchId = null;

    function sendLocation(position) {
        const { latitude, longitude } = position.coords;
        document.getElementById('live-coords').innerText = `Lat: ${latitude.toFixed(6)}, Lng: ${longitude.toFixed(6)}`;

        fetch('{{ route("location.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ latitude, longitude })
        })
        .then(response => response.json())
        .catch(err => console.error('Error sending location:', err));
    }

    function startTracking() {
        if ("geolocation" in navigator) {
            watchId = navigator.geolocation.watchPosition(sendLocation, (error) => {
                console.error("Geolocation error:", error);
                document.getElementById('live-coords').innerText = "Geolocation error. Please check permissions.";
            }, {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0
            });
        } else {
            alert("Geolocation is not supported by your browser.");
        }
    }

    document.getElementById('toggle-tracking').addEventListener('click', function() {
        isTracking = !isTracking;
        if (isTracking) {
            this.innerText = 'Pause Tracking';
            this.style.background = 'var(--primary)';
            document.getElementById('tracking-status').innerHTML = '<span class="pulse"></span> Active Tracking';
            document.getElementById('tracking-status').style.color = '#4ade80';
            startTracking();
        } else {
            this.innerText = 'Resume Tracking';
            this.style.background = '#f43f5e';
            document.getElementById('tracking-status').innerHTML = 'Tracking Paused';
            document.getElementById('tracking-status').style.color = '#94a3b8';
            if (watchId) navigator.geolocation.clearWatch(watchId);
        }
    });

    // Start on load
    startTracking();
</script>
@endsection
