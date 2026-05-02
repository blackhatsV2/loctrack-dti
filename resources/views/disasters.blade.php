@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    /* Consistent Map Styles with Employee Page */
    .disaster-container {
        display: flex;
        gap: 0;
        height: calc(100vh - 140px);
        min-height: 600px;
        border-radius: 1.5rem;
        overflow: hidden;
        border: 1px solid var(--glass-border);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    .sidebar-section {
        width: 380px;
        min-width: 380px;
        background: var(--glass);
        backdrop-filter: blur(12px);
        border-right: 1px solid var(--glass-border);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .map-section {
        flex: 1;
        position: relative;
        background: #0f172a;
    }

    #disaster-map {
        width: 100%;
        height: 100%;
    }

    .event-list {
        flex: 1;
        overflow-y: auto;
        padding: 1rem;
    }

    .event-list::-webkit-scrollbar { width: 4px; }
    .event-list::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 2px; }

    .event-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--glass-border);
        border-radius: 0.75rem;
        padding: 1rem;
        margin-bottom: 0.75rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .event-card:hover {
        background: rgba(99, 102, 241, 0.08);
        border-color: var(--primary);
    }

    .event-card.active {
        border-color: var(--primary);
        background: rgba(99, 102, 241, 0.1);
    }

    .badge {
        display: inline-block;
        padding: 0.2rem 0.5rem;
        border-radius: 0.4rem;
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
    }

    .badge-earthquake { background: rgba(244, 63, 94, 0.2); color: #fb7185; }
    .badge-nasa { background: rgba(59, 130, 246, 0.2); color: #60a5fa; }

    .event-time { font-size: 0.7rem; color: var(--text-muted); }

    .filter-pill {
        padding: 0.4rem 0.8rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--glass-border);
        color: var(--text-muted);
        cursor: pointer;
        transition: all 0.2s;
    }

    .filter-pill.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .legend {
        position: absolute;
        bottom: 1.5rem;
        left: 1.5rem;
        background: var(--glass);
        backdrop-filter: blur(12px);
        padding: 0.75rem;
        border-radius: 0.75rem;
        border: 1px solid var(--glass-border);
        z-index: 1000;
        font-size: 0.75rem;
    }

    .legend-item { display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem; }
    .dot { width: 8px; height: 8px; border-radius: 50%; }

    @media (max-width: 1024px) {
        .disaster-container { flex-direction: column; height: auto; }
        .sidebar-section { width: 100%; max-height: 400px; border-right: none; border-bottom: 1px solid var(--glass-border); }
        .map-section { height: 500px; }
    }
</style>
@endsection

@section('content')
<div class="animate-fade-in">
    <div style="margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h1 style="font-size: 1.75rem; margin-bottom: 0.25rem;">Live Disaster Tracker</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Monitoring real-time hazards and geological data</p>
        </div>
    </div>

    <div class="disaster-container">
        <div class="sidebar-section">
            <div style="padding: 1.25rem; border-bottom: 1px solid var(--glass-border);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h3 style="font-size: 1rem; font-weight: 600;">Hazards</h3>
                    <button onclick="refreshData()" class="btn btn-ghost" style="padding: 0.3rem 0.6rem; font-size: 0.75rem;">
                        <span id="refresh-icon">🔄</span> Sync
                    </button>
                </div>
                <div style="display: flex; gap: 0.5rem;">
                    <button onclick="setFilter('all')" class="filter-pill active" id="filter-all">All</button>
                    <button onclick="setFilter('earthquake')" class="filter-pill" id="filter-earthquake">USGS</button>
                    <button onclick="setFilter('nasa')" class="filter-pill" id="filter-nasa">NASA</button>
                </div>
            </div>
            
            <div class="event-list" id="event-list">
                <div style="text-align: center; padding: 2rem; color: var(--text-muted);">
                    <div class="spinner" style="margin: 0 auto 1rem;"></div>
                    Connecting to data sources...
                </div>
            </div>
        </div>

        <div class="map-section">
            <div id="disaster-map"></div>
            
            <button onclick="recenterPH()" class="btn btn-primary" style="position: absolute; top: 1.5rem; left: 1.5rem; z-index: 1000; padding: 0.5rem 1rem; border-radius: 0.75rem; font-size: 0.8rem; box-shadow: 0 4px 15px rgba(0,0,0,0.3);">
                📍 Recenter PH
            </button>

            <div class="legend">
                <div style="font-weight: 600; margin-bottom: 0.4rem;">Legend</div>
                <div class="legend-item"><span class="dot" style="background: #fb7185;"></span> Earthquakes</div>
                <div class="legend-item"><span class="dot" style="background: #60a5fa;"></span> NASA Events</div>
                <div class="legend-item"><span style="display:inline-block; width:12px; height:2px; background:#f87171; border-radius:1px;"></span> Active Faults</div>
                <div class="legend-item"><span class="dot" style="background: #fbbf24; border: 1px solid #d97706;"></span> Volcanoes</div>
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
    let activeFilter = 'all';

    document.addEventListener('DOMContentLoaded', function() {
        initMap();
        refreshData();
    });

    function initMap() {
        // Center on Philippines - Same as Employee Map
        map = L.map('disaster-map', {
            zoomControl: false,
            attributionControl: false,
            preferCanvas: true
        }).setView([12.8797, 121.7740], 6);

        const dark = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
            attribution: '&copy; CARTO'
        }).addTo(map);

        const streets = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OSM'
        });

        const satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: '&copy; Esri'
        });

        const baseMaps = {
            "Dark Mode": dark,
            "Streets": streets,
            "Satellite": satellite
        };

        const overlayMaps = {};
        const layerControl = L.control.layers(baseMaps, overlayMaps, { position: 'topright', collapsed: true }).addTo(map);
        L.control.zoom({ position: 'topright' }).addTo(map);

        // 1. GEM Active Faults (Loaded from LOCAL optimized file)
        fetch('/maps/ph_faults.json')
            .then(r => r.json())
            .then(data => {
                const faultsLayer = L.geoJSON(data, {
                    style: { color: '#f87171', weight: 2, opacity: 0.8, dashArray: '5, 5' },
                    onEachFeature: (feature, layer) => {
                        layer.bindPopup(`<b>Fault:</b> ${feature.properties.name || 'Unnamed'}`);
                    }
                }).addTo(map);
                layerControl.addOverlay(faultsLayer, "Active Faults");
            })
            .catch(e => console.error('Faults load error:', e));
        // 2. Volcanoes (Loaded from LOCAL file to avoid CORS)
        fetch('/maps/ph_volcanoes.json')
            .then(r => r.json())
            .then(data => {
                const volcanoLayer = L.geoJSON(data, {
                    pointToLayer: (f, latlng) => L.circleMarker(latlng, {
                        radius: 6,
                        fillColor: '#fbbf24',
                        color: '#d97706',
                        weight: 2,
                        opacity: 1,
                        fillOpacity: 0.8
                    }),
                    onEachFeature: (f, l) => l.bindPopup(`<b>Volcano:</b> ${f.properties.VolcanoName || f.properties.Volcano_Name || 'Unnamed'}`)
                }).addTo(map);
                layerControl.addOverlay(volcanoLayer, "Active Volcanoes");
            })
            .catch(err => console.error('Error loading volcanoes:', err));
    }
    function recenterPH() {
        map.flyTo([12.8797, 121.7740], 6);
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
        } finally {
            refreshIcon.style.animation = 'none';
        }
    }

    function setFilter(filter) {
        activeFilter = filter;
        document.querySelectorAll('.filter-pill').forEach(btn => btn.classList.remove('active'));
        document.getElementById(`filter-${filter}`).classList.add('active');
        renderMarkers();
        renderList();
    }

    function formatDisasterTime(timestamp) {
        const date = new Date(timestamp);
        return date.toLocaleString();
    }

    function renderMarkers() {
        markers.forEach(m => map.removeLayer(m));
        markers = [];

        if (activeFilter === 'all' || activeFilter === 'earthquake') {
            earthquakeData.forEach(eq => {
                const [lon, lat, depth] = eq.geometry.coordinates;
                const mag = eq.properties.mag;
                const time = new Date(eq.properties.time);
                
                // Format coordinates
                const latStr = Math.abs(lat).toFixed(3) + '°' + (lat >= 0 ? 'N' : 'S');
                const lonStr = Math.abs(lon).toFixed(3) + '°' + (lon >= 0 ? 'E' : 'W');
                
                // Format time string to match user's request exactly
                const year = time.getFullYear();
                const month = String(time.getMonth() + 1).padStart(2, '0');
                const day = String(time.getDate()).padStart(2, '0');
                const hours = String(time.getHours()).padStart(2, '0');
                const minutes = String(time.getMinutes()).padStart(2, '0');
                const seconds = String(time.getSeconds()).padStart(2, '0');
                
                const timezoneOffset = -time.getTimezoneOffset();
                const offsetHours = Math.floor(Math.abs(timezoneOffset) / 60);
                const offsetMinutes = Math.abs(timezoneOffset) % 60;
                const offsetSign = timezoneOffset >= 0 ? '+' : '-';
                const offsetStr = `(UTC${offsetSign}${String(offsetHours).padStart(2, '0')}:${String(offsetMinutes).padStart(2, '0')})`;
                
                const formattedTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds} ${offsetStr}`;

                const marker = L.circleMarker([lat, lon], {
                    radius: Math.max(mag * 3, 5),
                    fillColor: '#fb7185',
                    color: '#f43f5e',
                    weight: 1,
                    opacity: 0.8,
                    fillOpacity: 0.4
                }).addTo(map);

                marker.bindPopup(`
                    <div style="min-width: 200px;">
                        <div style="font-weight: 600; color: #f43f5e; margin-bottom: 4px; font-size: 0.95rem;">M ${mag} Earthquake</div>
                        <div style="font-size: 0.85rem; margin-bottom: 8px; font-weight: 500;">${eq.properties.place}</div>
                        <div style="display: grid; grid-template-columns: 70px 1fr; gap: 4px; font-size: 0.8rem; line-height: 1.4;">
                            <span style="color: #94a3b8;">Time</span><span>${formattedTime}</span>
                            <span style="color: #94a3b8;">Location</span><span>${latStr} ${lonStr}</span>
                            <span style="color: #94a3b8;">Depth</span><span>${depth ? depth.toFixed(1) + ' km' : 'N/A'}</span>
                        </div>
                    </div>
                `);
                markers.push(marker);
            });
        }

        if (activeFilter === 'all' || activeFilter === 'nasa') {
            nasaData.forEach(event => {
                const geo = event.geometry?.[0];
                if (!geo || geo.type !== 'Point') return;
                const [lon, lat] = geo.coordinates;
                const marker = L.circleMarker([lat, lon], {
                    radius: 6,
                    fillColor: '#60a5fa',
                    color: '#3b82f6',
                    weight: 1,
                    opacity: 0.8,
                    fillOpacity: 0.4
                }).addTo(map);

                const eventTime = geo.date ? new Date(geo.date).toLocaleString() : 'Date N/A';
                const latStr = Math.abs(lat).toFixed(3) + '°' + (lat >= 0 ? 'N' : 'S');
                const lonStr = Math.abs(lon).toFixed(3) + '°' + (lon >= 0 ? 'E' : 'W');

                marker.bindPopup(`
                    <div style="min-width: 200px;">
                        <div style="font-weight: 600; color: #3b82f6; margin-bottom: 4px; font-size: 0.95rem;">${event.categories[0]?.title || 'Natural Event'}</div>
                        <div style="font-size: 0.85rem; margin-bottom: 8px; font-weight: 500;">${event.title}</div>
                        <div style="display: grid; grid-template-columns: 70px 1fr; gap: 4px; font-size: 0.8rem; line-height: 1.4;">
                            <span style="color: #94a3b8;">Time</span><span>${eventTime}</span>
                            <span style="color: #94a3b8;">Location</span><span>${latStr} ${lonStr}</span>
                        </div>
                    </div>
                `);
                markers.push(marker);
            });
        }
    }

    function renderList() {
        const listContainer = document.getElementById('event-list');
        listContainer.innerHTML = '';

        const allEvents = [
            ...(activeFilter === 'all' || activeFilter === 'earthquake' ? earthquakeData.map(e => ({
                type: 'earthquake',
                title: e.properties.place,
                mag: e.properties.mag,
                time: e.properties.time,
                lat: e.geometry.coordinates[1],
                lon: e.geometry.coordinates[0]
            })) : []),
            ...(activeFilter === 'all' || activeFilter === 'nasa' ? nasaData.map(e => ({
                type: 'nasa',
                title: e.title,
                category: e.categories[0]?.title,
                time: new Date(e.geometry?.[0]?.date).getTime(),
                lat: e.geometry?.[0]?.coordinates[1],
                lon: e.geometry?.[0]?.coordinates[0]
            })) : [])
        ].sort((a, b) => b.time - a.time);

        if (allEvents.length === 0) {
            listContainer.innerHTML = '<div style="text-align: center; padding: 2rem; color: var(--text-muted);">No recent events found.</div>';
            return;
        }

        allEvents.forEach(event => {
            const card = document.createElement('div');
            card.className = 'event-card';
            card.innerHTML = `
                <div class="badge ${event.type === 'earthquake' ? 'badge-earthquake' : 'badge-nasa'}">${event.type === 'earthquake' ? 'Earthquake' : event.category}</div>
                <div style="font-weight: 600; font-size: 0.9rem; margin-bottom: 0.25rem;">${event.type === 'earthquake' ? 'M ' + event.mag + ' - ' : ''}${event.title}</div>
                <div class="event-time">${formatDisasterTime(event.time)}</div>
            `;
            card.onclick = () => {
                map.flyTo([event.lat, event.lon], 10);
                document.querySelectorAll('.event-card').forEach(c => c.classList.remove('active'));
                card.classList.add('active');
            };
            listContainer.appendChild(card);
        });
    }
</script>
@endsection
