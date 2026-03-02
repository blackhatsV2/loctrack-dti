@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    #map {
        height: 600px;
        width: 100%;
        border-radius: 1.5rem;
        border: 1px solid var(--glass-border);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
    }
    .leaflet-popup-content-wrapper {
        background: var(--bg-dark);
        color: var(--text-light);
        border: 1px solid var(--glass-border);
        backdrop-filter: blur(8px);
    }
    .leaflet-popup-tip {
        background: var(--bg-dark);
    }
</style>
@endsection

@section('content')
<div class="animate-fade-in">
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; margin-bottom: 0.5rem;">Real-time Employee Map</h1>
            <p style="color: var(--text-muted);">Visualizing current locations of all active team members.</p>
        </div>
        <div style="font-size: 0.875rem; color: var(--text-muted);">
            Last updated: <span id="last-update">Just now</span>
        </div>
    </div>

    <div id="map"></div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    const map = L.map('map').setView([10.6897, 122.5154], 10); // Center on provided link area

    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
        subdomains: 'abcd',
        maxZoom: 20
    }).addTo(map);

    let markers = {};

    function updateMap() {
        fetch('{{ route("location.index") }}')
            .then(response => response.json())
            .then(data => {
                data.forEach(loc => {
                    const lat = parseFloat(loc.latitude);
                    const lng = parseFloat(loc.longitude);
                    const userName = loc.user.name;
                    const idNo = loc.employee_id_no || 'N/A';
                    const office = loc.office || 'N/A';
                    const address = loc.address || 'N/A';
                    const mobile = loc.mobile_no || 'N/A';
                    const empType = loc.employee_type || 'N/A';

                    const popupContent = `
                        <div style="min-width: 200px;">
                            <b style="font-size: 1.05em;">${userName}</b><br>
                            <small style="opacity: 0.7;">ID: ${idNo} | ${empType}</small>
                            <hr style="border-color: rgba(255,255,255,0.15); margin: 6px 0;">
                            <b>Office:</b> ${office}<br>
                            <b>Address:</b> ${address}<br>
                            <b>Mobile:</b> ${mobile}
                        </div>
                    `;

                    if (markers[loc.user_id]) {
                        markers[loc.user_id].setLatLng([lat, lng]);
                        markers[loc.user_id].getPopup().setContent(popupContent);
                    } else {
                        const marker = L.marker([lat, lng]).addTo(map)
                            .bindPopup(popupContent);
                        markers[loc.user_id] = marker;
                    }
                });
                document.getElementById('last-update').innerText = new Date().toLocaleTimeString();
            })
            .catch(err => console.error('Error fetching locations:', err));
    }

    // Update every 10 seconds
    setInterval(updateMap, 10000);
    updateMap();
</script>
@endsection
