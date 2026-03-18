@extends('layouts.app')

@section('styles')
@vite(['resources/js/map-bundle.js'])
<style>
    .profile-card {
        margin-bottom: 2rem;
    }
    .address-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .address-card {
        padding: 1.5rem;
        position: relative;
    }
    .address-type {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    .address-value {
        font-size: 1.1rem;
        color: var(--text-light);
        margin-bottom: 1rem;
        min-height: 3rem;
    }
    .minimap-container {
        height: 350px;
        width: 100%;
        border-radius: 1rem;
        border: 1px solid var(--glass-border);
        margin-top: 1rem;
    }
    .modal {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(15, 23, 42, 0.8);
        backdrop-filter: blur(8px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }
    .modal.active { display: flex; }
    .modal-content {
        width: 90%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
    }
    .input-group {
        margin-bottom: 1.25rem;
    }
    .input-label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--text-muted);
        font-size: 0.9rem;
    }
    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid var(--glass-border);
        color: white;
        font-family: 'Outfit', sans-serif;
    }
    .map-picker {
        height: 300px;
        width: 100%;
        border-radius: 0.75rem;
        border: 1px solid var(--glass-border);
        margin-top: 0.5rem;
    }
    .btn-small {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
    }
    .recommendation-alert {
        background: rgba(245, 158, 11, 0.1);
        border: 1px solid rgba(245, 158, 11, 0.2);
        color: #f59e0b;
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
        font-size: 0.85rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    @media (max-width: 768px) {
        .address-section { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="animate-fade-in">
    <div class="glass-card profile-card">
        <div style="display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
            <div style="width: 80px; height: 80px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; box-shadow: 0 0 20px rgba(99, 102, 241, 0.3);">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div style="flex-grow: 1;">
                <h1 style="font-size: 2rem; margin-bottom: 0.25rem;">{{ $user->name }}</h1>
                <p style="color: var(--text-muted); font-size: 1rem;">
                    {{ $location->employee_type ?? 'Staff' }} | {{ $location->employee_id_no ?? 'ID: N/A' }}
                </p>
                <div style="display: flex; gap: 1rem; margin-top: 0.75rem; font-size: 0.9rem; color: var(--text-muted);">
                    <span>📧 {{ $user->email }}</span>
                    <span>📱 {{ $location->mobile_no ?? 'No mobile set' }}</span>
                </div>
            </div>
            <div id="tracking-indicator" style="padding: 0.5rem 1rem; background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); border-radius: 2rem; color: #10b981; font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <span class="pulse-green"></span> Live Tracking Active
            </div>
        </div>
    </div>

    <div class="address-section">
        <!-- Home Address Card -->
        <div class="glass-card address-card">
            <div class="address-type" style="color: var(--primary);">🏠 Home Address</div>
            <div class="address-value" id="home-address-display">
                {{ $location->address ?? 'Not set' }}
            </div>
            <button onclick="openAddressModal('home')" class="btn btn-small">
                {{ $location->address ? 'Change' : 'Set New' }} Home Address
            </button>
        </div>

        <!-- Office Address Card -->
        <div class="glass-card address-card">
            <div class="address-type" style="color: #f472b6;">🏢 Office Assignment</div>
            <div class="address-value" id="office-address-display">
                {{ $location->office ?? 'Not set' }}
            </div>
            <button onclick="openAddressModal('office')" class="btn btn-small" style="background: #f472b6;">
                {{ $location->office ? 'Change' : 'Set New' }} Office Address
            </button>
        </div>
    </div>

    <div class="glass-card">
        <h3 style="margin-bottom: 1rem;">📍 Your Location Overview</h3>
        <div id="minimap" class="minimap-container"></div>
    </div>
</div>

<!-- Address Update Modal -->
<div id="address-modal" class="modal">
    <div class="glass-card modal-content animate-fade-in">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2 id="modal-title">Set Address</h2>
            <button onclick="closeAddressModal()" style="background: transparent; border: none; color: white; font-size: 1.5rem; cursor: pointer;">&times;</button>
        </div>

        <div class="recommendation-alert">
            <span>💡</span>
            <span>We recommend manually selecting on the map for better accuracy.</span>
        </div>

        <form id="address-form">
            <input type="hidden" id="addr-type" name="type">
            <input type="hidden" id="addr-lat" name="latitude">
            <input type="hidden" id="addr-lng" name="longitude">

            <div class="input-group">
                <label class="input-label">Address Name / Label</label>
                <div style="display: flex; gap: 0.5rem;">
                    <input type="text" id="addr-text" name="address" class="form-input" placeholder="e.g. My Home or Office Name" required>
                    <button type="button" onclick="getCurrentLocation()" class="btn btn-small" style="white-space: nowrap; background: #06b6d4;">
                        📍 Auto-detect
                    </button>
                </div>
            </div>

            <div class="input-group">
                <label class="input-label">Select on Map (Click to pick location)</label>
                <div id="map-picker" class="map-picker"></div>
                <small style="color: var(--text-muted); margin-top: 0.5rem; display: block;">
                    Selected: <span id="coords-text">None</span>
                </small>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="button" onclick="closeAddressModal()" class="btn" style="background: rgba(255,255,255,0.1); flex: 1;">Cancel</button>
                <button type="submit" class="btn" style="flex: 2;">Save Address</button>
            </div>
        </form>
    </div>
</div>

<style>
    .pulse-green {
        display: inline-block;
        width: 10px;
        height: 10px;
        background: #10b981;
        border-radius: 50%;
        box-shadow: 0 0 0 rgba(16, 185, 129, 0.4);
        animation: pulse-green 2s infinite;
    }
    @keyframes pulse-green {
        0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
        100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
</style>
@endsection

@section('scripts')
<script>
    let minimap, pickerMap, pickerMarker;
    const userLocation = @json($location);
    const initialLat = userLocation?.latitude || 10.7202;
    const initialLng = userLocation?.longitude || 122.5621;

    function initMaps() {
        if (typeof L === 'undefined') {
            setTimeout(initMaps, 100);
            return;
        }

        // Main Dashboard Minimap
        minimap = L.map('minimap', { scrollWheelZoom: false }).setView([initialLat, initialLng], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(minimap);

        if (userLocation?.latitude) {
            L.marker([userLocation.latitude, userLocation.longitude])
                .addTo(minimap)
                .bindPopup("<b>Current Tracked Location</b>")
                .openPopup();
        }

        // Picker Map for Modal
        pickerMap = L.map('map-picker').setView([initialLat, initialLng], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(pickerMap);

        pickerMap.on('click', function(e) {
            setPickerLocation(e.latlng.lat, e.latlng.lng);
        });
    }

    function setPickerLocation(lat, lng) {
        if (pickerMarker) pickerMap.removeLayer(pickerMarker);
        pickerMarker = L.marker([lat, lng]).addTo(pickerMap);
        document.getElementById('addr-lat').value = lat;
        document.getElementById('addr-lng').value = lng;
        document.getElementById('coords-text').innerText = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
    }

    function openAddressModal(type) {
        document.getElementById('addr-type').value = type;
        document.getElementById('modal-title').innerText = type === 'home' ? 'Set Home Address' : 'Set Office Assignment';
        document.getElementById('address-modal').classList.add('active');
        
        // Fix for Leaflet map grey tiles when opened in modal
        setTimeout(() => {
            pickerMap.invalidateSize();
            if (userLocation?.latitude) {
                pickerMap.setView([userLocation.latitude, userLocation.longitude], 15);
                setPickerLocation(userLocation.latitude, userLocation.longitude);
            }
        }, 100);
    }

    function closeAddressModal() {
        document.getElementById('address-modal').classList.remove('active');
    }

    function getCurrentLocation() {
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition((position) => {
                const { latitude, longitude } = position.coords;
                pickerMap.setView([latitude, longitude], 17);
                setPickerLocation(latitude, longitude);
            }, (err) => {
                alert("Could not get location: " + err.message);
            });
        } else {
            alert("Geolocation not supported.");
        }
    }

    // Form Submission
    document.getElementById('address-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const data = {
            address: document.getElementById('addr-text').value,
            latitude: document.getElementById('addr-lat').value,
            longitude: document.getElementById('addr-lng').value,
            type: document.getElementById('addr-type').value,
        };

        if (!data.latitude || !data.longitude) {
            alert("Please pick a location on the map.");
            return;
        }

        fetch('{{ route("location.updateAddress") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(res => {
            if (res.status === 'success') {
                alert(res.message);
                window.location.reload();
            }
        })
        .catch(err => console.error(err));
    });

    // Tracking Logic (keeping simple background tracking)
    function startLiveTracking() {
        if ("geolocation" in navigator) {
            navigator.geolocation.watchPosition((pos) => {
                fetch('{{ route("location.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        latitude: pos.coords.latitude,
                        longitude: pos.coords.longitude
                    })
                });
            }, null, { enableHighAccuracy: true });
        }
    }

    window.onload = () => {
        initMaps();
        startLiveTracking();
    };
</script>
@endsection
