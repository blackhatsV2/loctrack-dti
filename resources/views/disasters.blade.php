@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .disaster-container {
        display: flex;
        gap: 1.5rem;
        height: calc(100vh - 180px);
        min-height: 600px;
    }

    .map-section {
        flex: 1;
        position: relative;
        border-radius: 1.5rem;
        overflow: hidden;
        border: 1px solid var(--glass-border);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    #disaster-map {
        width: 100%;
        height: 100%;
        background: #0f172a;
    }

    .sidebar-section {
        width: 380px;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .event-card {
        background: var(--glass);
        backdrop-filter: blur(12px);
        border: 1px solid var(--glass-border);
        border-radius: 1rem;
        padding: 1rem;
        margin-bottom: 0.75rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .event-card:hover {
        background: rgba(255, 255, 255, 0.05);
        transform: translateY(-2px);
        border-color: var(--primary);
    }

    .event-card.active {
        border-color: var(--primary);
        background: rgba(99, 102, 241, 0.1);
    }

    .event-list {
        flex: 1;
        overflow-y: auto;
        padding-right: 0.5rem;
    }

    .event-list::-webkit-scrollbar {
        width: 6px;
    }

    .event-list::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 3px;
    }

    .badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 0.5rem;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
    }

    .badge-earthquake { background: rgba(244, 63, 94, 0.2); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.3); }
    .badge-nasa { background: rgba(59, 130, 246, 0.2); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3); }

    .magnitude {
        font-size: 1.25rem;
        font-weight: 600;
        color: #fb7185;
    }

    .event-time {
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    .pulsing-marker {
        border-radius: 50%;
        background: rgba(244, 63, 94, 0.6);
        box-shadow: 0 0 0 rgba(244, 63, 94, 0.4);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(244, 63, 94, 0.7); }
        70% { box-shadow: 0 0 0 15px rgba(244, 63, 94, 0); }
        100% { box-shadow: 0 0 0 0 rgba(244, 63, 94, 0); }
    }

    .legend {
        position: absolute;
        bottom: 1.5rem;
        left: 1.5rem;
        background: var(--glass);
        backdrop-filter: blur(12px);
        padding: 1rem;
        border-radius: 1rem;
        border: 1px solid var(--glass-border);
        z-index: 1000;
        font-size: 0.8rem;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.25rem;
    }

    .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }

    @media (max-width: 1024px) {
        .disaster-container {
            flex-direction: column;
            height: auto;
        }
        .sidebar-section {
            width: 100%;
        }
        .map-section {
            height: 500px;
        }
    }
</style>
@endsection

@section('content')
<div class="animate-fade-in">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; background: linear-gradient(to right, #f87171, #fb923c); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Live Disaster Tracker</h1>
        <p style="color: var(--text-muted);">Real-time alerts from USGS, NASA EONET, and local observers.</p>
    </div>

    <div class="disaster-container">
        <div class="sidebar-section">
            <div class="glass-card" style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem; height: 100%;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 1.1rem;">Recent Events</h3>
                    <button onclick="refreshData()" class="btn btn-ghost" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;">
                        <span id="refresh-icon">🔄</span> Refresh
                    </button>
                </div>
                
                <div class="event-list" id="event-list">
                    <div style="text-align: center; padding: 2rem; color: var(--text-muted);">
                        <div class="spinner" style="margin: 0 auto 1rem;"></div>
                        Loading live data...
                    </div>
                </div>
            </div>
        </div>

        <div class="map-section">
            <div id="disaster-map"></div>
            
            <div class="legend">
                <div style="font-weight: 600; margin-bottom: 0.5rem;">Legend</div>
                <div class="legend-item"><span class="dot" style="background: #fb7185;"></span> Earthquakes (USGS)</div>
                <div class="legend-item"><span class="dot" style="background: #60a5fa;"></span> Natural Events (NASA)</div>
                <div class="legend-item"><span class="dot" style="background: #a855f7;"></span> Local Alerts (PHIVOLCS/PAGASA)</div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let map;
    let markers = [];
    let earthquakeData = [];
    let nasaData = [];

    document.addEventListener('DOMContentLoaded', function() {
        initMap();
        refreshData();
    });

    function initMap() {
        // Center on Philippines
        map = L.map('disaster-map', {
            zoomControl: false,
            attributionControl: false
        }).setView([12.8797, 121.7740], 6);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            maxZoom: 19
        }).addTo(map);

        L.control.zoom({ position: 'topright' }).addTo(map);
    }

    async function refreshData() {
        const refreshIcon = document.getElementById('refresh-icon');
        refreshIcon.style.display = 'inline-block';
        refreshIcon.style.animation = 'spin 1s linear infinite';

        try {
            const [eqRes, nasaRes] = await Promise.all([
                fetch('{{ route("api.disasters.earthquakes") }}').then(r => r.json()),
                fetch('{{ route("api.disasters.events") }}').then(r => r.json())
            ]);

            earthquakeData = eqRes.features || [];
            nasaData = nasaRes.events || [];

            renderMarkers();
            renderList();
        } catch (error) {
            console.error('Error fetching disaster data:', error);
            showToast('Error', 'Failed to fetch some disaster updates.', 'error');
        } finally {
            refreshIcon.style.animation = 'none';
        }
    }

    function formatDisasterTime(timestamp) {
        const date = new Date(timestamp);
        const yyyy = date.getFullYear();
        const mm = String(date.getMonth() + 1).padStart(2, '0');
        const dd = String(date.getDate()).padStart(2, '0');
        const hh = String(date.getHours()).padStart(2, '0');
        const min = String(date.getMinutes()).padStart(2, '0');
        const ss = String(date.getSeconds()).padStart(2, '0');
        
        const offset = -date.getTimezoneOffset();
        const absOffset = Math.abs(offset);
        const offsetHours = String(Math.floor(absOffset / 60)).padStart(2, '0');
        const offsetMin = String(absOffset % 60).padStart(2, '0');
        const offsetStr = `UTC${offset >= 0 ? '+' : '-'}${offsetHours}:${offsetMin}`;
        
        return `${yyyy}-${mm}-${dd} ${hh}:${min}:${ss} (${offsetStr})`;
    }

    function renderMarkers() {
        // Clear old markers
        markers.forEach(m => map.removeLayer(m));
        markers = [];

        // Earthquakes
        earthquakeData.forEach(eq => {
            const [lon, lat] = eq.geometry.coordinates;
            const mag = eq.properties.mag;
            const place = eq.properties.place;
            const time = new Date(eq.properties.time).toLocaleString();

            const marker = L.circleMarker([lat, lon], {
                radius: Math.max(mag * 3, 5),
                fillColor: '#fb7185',
                color: '#f43f5e',
                weight: 1,
                opacity: 0.8,
                fillOpacity: 0.4,
                className: mag > 5.0 ? 'pulsing-marker' : ''
            }).addTo(map);

            const depth = eq.geometry.coordinates[2];
            marker.bindPopup(`
                <div class="popup-content" style="min-width: 200px; font-family: 'Outfit', sans-serif;">
                    <div style="font-weight: 700; color: #fb7185; margin-bottom: 0.6rem; font-size: 1rem; line-height: 1.4;">
                        M ${mag} - ${place}
                    </div>
                    <div style="display: grid; grid-template-columns: auto 1fr; gap: 0.4rem 0.8rem; font-size: 0.85rem;">
                        <span style="color: #94a3b8;">Time</span>
                        <span>${formatDisasterTime(eq.properties.time)}</span>
                        
                        <span style="color: #94a3b8;">Location</span>
                        <span>${lat.toFixed(3)}°N ${lon.toFixed(3)}°E</span>
                        
                        <span style="color: #94a3b8;">Depth</span>
                        <span>${depth ? depth.toFixed(1) + ' km' : 'N/A'}</span>
                    </div>
                </div>
            `);

            markers.push(marker);
        });

        // NASA Events
        nasaData.forEach(event => {
            const geo = event.geometry?.[0];
            if (!geo || geo.type !== 'Point') return;

            const [lon, lat] = geo.coordinates;
            const title = event.title;
            const category = event.categories[0]?.title || 'Natural Event';

            // Check if in/near PH bounding box if you want to filter strictly
            // But NASA events often cover large areas. 
            // For now show all NASA events returned by API (limited to 50).

            const marker = L.circleMarker([lat, lon], {
                radius: 8,
                fillColor: '#60a5fa',
                color: '#3b82f6',
                weight: 2,
                opacity: 0.9,
                fillOpacity: 0.3
            }).addTo(map);

            marker.bindPopup(`
                <div style="font-family: 'Outfit', sans-serif; min-width: 200px;">
                    <div style="font-weight: 600; color: #60a5fa; margin-bottom: 0.5rem; font-size: 1rem;">${category}</div>
                    <div style="font-size: 0.9rem; margin-bottom: 0.6rem; line-height: 1.4;">${title}</div>
                    <div style="font-size: 0.75rem; color: #94a3b8; margin-bottom: 0.6rem;">
                        ${formatDisasterTime(new Date(event.geometry?.[0]?.date).getTime())}
                    </div>
                    <a href="${event.sources[0]?.url}" target="_blank" style="font-size: 0.75rem; color: var(--primary); text-decoration: none; display: flex; align-items: center; gap: 0.25rem;">
                        View USGS/NASA Source <span style="font-size: 1rem;">↗</span>
                    </a>
                </div>
            `);

            markers.push(marker);
        });
    }

    function renderList() {
        const listContainer = document.getElementById('event-list');
        listContainer.innerHTML = '';

        const allEvents = [
            ...earthquakeData.map(e => ({
                type: 'earthquake',
                title: e.properties.place,
                mag: e.properties.mag,
                time: e.properties.time,
                lat: e.geometry.coordinates[1],
                lon: e.geometry.coordinates[0],
                depth: e.geometry.coordinates[2],
                raw: e
            })),
            ...nasaData.map(e => ({
                type: 'nasa',
                title: e.title,
                category: e.categories[0]?.title,
                time: new Date(e.geometry?.[0]?.date).getTime(),
                lat: e.geometry?.[0]?.coordinates[1],
                lon: e.geometry?.[0]?.coordinates[0],
                raw: e
            }))
        ].sort((a, b) => b.time - a.time);

        if (allEvents.length === 0) {
            listContainer.innerHTML = '<div style="text-align: center; padding: 2rem; color: var(--text-muted);">No recent events found.</div>';
            return;
        }

        allEvents.forEach(event => {
            const card = document.createElement('div');
            card.className = 'event-card';
            
            if (event.type === 'earthquake') {
                card.innerHTML = `
                    <div class="badge badge-earthquake">Earthquake</div>
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.4rem;">
                        <div style="font-weight: 600; font-size: 0.95rem; flex: 1; color: var(--text-bright); line-height: 1.3;">M ${event.mag} - ${event.title}</div>
                    </div>
                    <div class="event-time" style="margin-bottom: 0.3rem;">${formatDisasterTime(event.time)}</div>
                    <div style="font-size: 0.75rem; opacity: 0.5;">Depth: ${event.depth ? event.depth.toFixed(1) + ' km' : 'N/A'}</div>
                `;
            } else {
                card.innerHTML = `
                    <div class="badge badge-nasa">${event.category || 'Event'}</div>
                    <div style="font-weight: 600; font-size: 0.95rem; margin-bottom: 0.4rem; color: var(--text-bright); line-height: 1.3;">${event.title}</div>
                    <div class="event-time">${formatDisasterTime(event.time)}</div>
                `;
            }

            card.onclick = () => {
                map.flyTo([event.lat, event.lon], 10, { duration: 1.5 });
                // We'd need a way to open the specific marker popup. 
                // For simplicity, just fly there.
                
                // Highlight active card
                document.querySelectorAll('.event-card').forEach(c => c.classList.remove('active'));
                card.classList.add('active');
                
                // If on mobile, scroll to map
                if (window.innerWidth <= 1024) {
                    document.getElementById('disaster-map').scrollIntoView({ behavior: 'smooth' });
                }
            };

            listContainer.appendChild(card);
        });
    }
</script>
@endsection
