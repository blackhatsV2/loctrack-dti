@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    :root {
        --sidebar-width-left: 300px;
        --sidebar-width-right: 360px;
    }

    .unified-container {
        display: flex;
        gap: 0;
        height: calc(100vh - 140px);
        min-height: 700px;
        border-radius: 1.5rem;
        overflow: hidden;
        border: 1px solid var(--glass-border);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        background: #0f172a;
    }

    .sidebar-left {
        width: var(--sidebar-width-left);
        min-width: var(--sidebar-width-left);
        background: var(--glass);
        backdrop-filter: blur(12px);
        border-right: 1px solid var(--glass-border);
        display: flex;
        flex-direction: column;
        z-index: 10;
    }

    .sidebar-right {
        width: var(--sidebar-width-right);
        min-width: var(--sidebar-width-right);
        background: var(--glass);
        backdrop-filter: blur(12px);
        border-left: 1px solid var(--glass-border);
        display: flex;
        flex-direction: column;
        z-index: 10;
    }

    .map-section {
        flex: 1;
        position: relative;
        background: #f1f5f9;
    }

    #map {
        width: 100%;
        height: 100%;
    }

    .sidebar-header {
        padding: 1.25rem;
        border-bottom: 1px solid var(--glass-border);
    }
    .sidebar-header h3 { font-size: 1rem; font-weight: 600; margin-bottom: 0.25rem; display: flex; align-items: center; gap: 0.5rem; }
    .sidebar-header small { color: var(--text-muted); font-size: 0.8rem; }

    .scroll-area {
        flex: 1;
        overflow-y: auto;
        padding: 0.5rem 0;
    }
    .scroll-area::-webkit-scrollbar { width: 4px; }
    .scroll-area::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 2px; }

    .filter-item {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.6rem 1.25rem;
        cursor: pointer;
        transition: background 0.15s;
        font-size: 0.85rem;
    }
    .filter-item:hover { background: rgba(255,255,255,0.03); }
    .filter-item input[type="checkbox"] { accent-color: var(--primary); width: 16px; height: 16px; }
    .filter-dot { width: 10px; height: 10px; border-radius: 50%; }
    .filter-count { font-size: 0.7rem; color: var(--text-muted); background: rgba(255,255,255,0.06); padding: 0.1rem 0.4rem; border-radius: 1rem; margin-left: auto; }

    .event-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--glass-border);
        border-radius: 0.75rem;
        padding: 0.85rem;
        margin: 0.5rem 1rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    .event-card:hover { border-color: var(--primary); background: rgba(99, 102, 241, 0.05); }
    .event-card.active { border-color: var(--primary); background: rgba(99, 102, 241, 0.1); }
    
    .badge {
        display: inline-block;
        padding: 0.15rem 0.45rem;
        border-radius: 0.4rem;
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 0.4rem;
    }
    .badge-earthquake { background: rgba(244, 63, 94, 0.2); color: #fb7185; }
    .badge-nasa { background: rgba(59, 130, 246, 0.2); color: #60a5fa; }
    .event-time { font-size: 0.7rem; color: var(--text-muted); margin-top: 0.25rem; }

    .search-container {
        padding: 0.75rem 1.25rem;
        border-bottom: 1px solid var(--glass-border);
    }
    .search-input {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
        background: rgba(0,0,0,0.2);
        border: 1px solid var(--glass-border);
        color: white;
        font-size: 0.85rem;
    }

    .map-loading {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(241, 245, 249, 0.9);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        z-index: 2000;
        gap: 1rem;
        transition: opacity 0.4s ease;
    }
    .map-loading.hidden {
        opacity: 0;
        pointer-events: none;
    }
    .loading-spinner { width: 40px; height: 40px; border: 3px solid rgba(99, 102, 241, 0.2); border-top-color: #6366f1; border-radius: 50%; animation: spin 0.8s linear infinite; }
    @keyframes spin { to { transform: rotate(360deg); } }

    .leaflet-popup-content-wrapper {
        background: #1e293b; color: #f1f5f9; border: 1px solid rgba(255,255,255,0.1); border-radius: 12px;
    }
    .leaflet-popup-tip { background: #1e293b; }

    @media (max-width: 1200px) {
        .sidebar-right { display: none; }
    }
    @media (max-width: 900px) {
        .sidebar-left { display: none; }
    }
</style>
@endsection

@section('content')
<div class="animate-fade-in">
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1rem;">
        <div>
            <h1 style="font-size: 1.75rem; margin-bottom: 0.25rem;">Unified Command Center</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Monitoring <span id="total-employees">0</span> employees and real-time global hazards</p>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <button onclick="refreshHazards()" class="btn btn-ghost" style="font-size: 0.8rem; padding: 0.4rem 0.8rem;">
                <span id="sync-icon">🔄</span> Sync Hazards
            </button>
            <button onclick="recenterPH()" class="btn btn-primary" style="font-size: 0.8rem; padding: 0.4rem 0.8rem;">
                📍 Recenter PH
            </button>
        </div>
    </div>

    <div class="unified-container">
        <!-- Left Sidebar: Employees -->
        <div class="sidebar-left">
            <div class="sidebar-header">
                <h3>👥 Employee Layers</h3>
                <small>Filter by office/category</small>
            </div>
            
            <div class="search-container">
                <input type="text" id="employee-search" class="search-input" placeholder="Search employees...">
            </div>

            <div class="scroll-area" id="employee-filters">
                <!-- Dynamic categories -->
            </div>

            <div style="padding: 1rem; border-top: 1px solid var(--glass-border); display: flex; gap: 0.5rem;">
                <button class="btn btn-ghost" style="flex: 1; font-size: 0.75rem;" onclick="toggleAllEmployees(false)">Hide All</button>
                <button class="btn btn-primary" style="flex: 1; font-size: 0.75rem;" onclick="toggleAllEmployees(true)">Show All</button>
            </div>
        </div>

        <!-- Main Map -->
        <div class="map-section">
            <div id="map"></div>
            <div class="map-loading" id="map-loading">
                <div class="loading-spinner"></div>
                <div style="color: var(--text-muted); font-size: 0.9rem;">Initializing Unified Map...</div>
            </div>
        </div>

        <!-- Right Sidebar: Hazards -->
        <div class="sidebar-right">
            <div class="sidebar-header">
                <h3>⚠️ Global Hazards</h3>
                <div style="display: flex; gap: 0.4rem; margin-top: 0.5rem;">
                    <button onclick="setHazardFilter('all')" class="btn btn-ghost active-hazard-filter" id="h-filter-all" style="padding: 0.2rem 0.5rem; font-size: 0.65rem;">All</button>
                    <button onclick="setHazardFilter('earthquake')" class="btn btn-ghost" id="h-filter-earthquake" style="padding: 0.2rem 0.5rem; font-size: 0.65rem;">USGS</button>
                    <button onclick="setHazardFilter('nasa')" class="btn btn-ghost" id="h-filter-nasa" style="padding: 0.2rem 0.5rem; font-size: 0.65rem;">NASA</button>
                </div>
            </div>

            <div class="scroll-area" id="hazard-list">
                <!-- Hazards list -->
            </div>

            <div style="padding: 1rem; border-top: 1px solid var(--glass-border);">
                <div style="font-size: 0.75rem; font-weight: 600; margin-bottom: 0.75rem; color: var(--text-muted);">STATIC LAYERS</div>
                <div class="filter-item" onclick="toggleStaticLayer('faults')">
                    <input type="checkbox" id="layer-faults" checked onclick="event.stopPropagation(); toggleStaticLayer('faults', true)">
                    <span style="display:inline-block; width:12px; height:2px; background:#f87171; border-radius:1px;"></span>
                    <span>Active Faults (PH)</span>
                </div>
                <div class="filter-item" onclick="toggleStaticLayer('volcanoes')">
                    <input type="checkbox" id="layer-volcanoes" checked onclick="event.stopPropagation(); toggleStaticLayer('volcanoes', true)">
                    <span class="filter-dot" style="background:#fbbf24; border:1px solid #d97706;"></span>
                    <span>Volcanoes (PH)</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let map;
    let employeeMarkers = [];
    let earthquakeMarkers = [];
    let nasaMarkers = [];
    let earthquakeData = [];
    let nasaData = [];
    let faultLayer, volcanoLayer;
    let staticLayersLoaded = false;
    let activeHazardFilter = 'all';
    let employeeFilters = {};

    const categories = [
        { key: 'NC Negros Occidental',  label: 'NC Negros Occidental', color: '#3b82f6' },
        { key: 'NC Ilolo',              label: 'NC Ilolo',             color: '#800000' },
        { key: 'NC Guimaras',           label: 'NC Guimaras',           color: '#eab308' },
        { key: 'NC Capiz',              label: 'NC Capiz',              color: '#8b5cf6' },
        { key: 'NC Antique',            label: 'NC Antique',            color: '#22c55e' },
        { key: 'NC AKlan',              label: 'NC AKlan',              color: '#f97316' },
        { key: 'DTI6 Regular Employees', label: 'DTI6 Regular Employees', color: '#3b82f6' },
        { key: 'other',                 label: 'other',                 color: '#94a3b8' },
    ];

    document.addEventListener('DOMContentLoaded', () => {
        initMap();
        loadEmployees();
        refreshHazards();
    });

    function initMap() {
        map = L.map('map', { zoomControl: false, attributionControl: false, preferCanvas: true }).setView([12.8797, 121.7740], 6);
        const gray = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { 
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);
        const satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}');
        L.control.layers({ "Standard Map": gray, "Satellite": satellite }, {}, { position: 'topleft' }).addTo(map);
        L.control.zoom({ position: 'bottomright' }).addTo(map);
    }

    async function loadStaticLayers() {
        try {
            const [fRes, vRes] = await Promise.all([
                fetch('/maps/ph_faults.json').then(r => r.json()),
                fetch('/maps/ph_volcanoes.json').then(r => r.json())
            ]);
            faultLayer = L.geoJSON(fRes, {
                style: { color: '#f87171', weight: 2, opacity: 0.8, dashArray: '5, 5' },
                onEachFeature: (f, l) => l.bindPopup(`<b>Fault:</b> ${f.properties.name || 'Unnamed'}`)
            }).addTo(map);
            volcanoLayer = L.geoJSON(vRes, {
                pointToLayer: (f, latlng) => L.circleMarker(latlng, { radius: 6, fillColor: '#fbbf24', color: '#d97706', weight: 1.5, opacity: 1, fillOpacity: 0.8 }),
                onEachFeature: (f, l) => l.bindPopup(`<b>Volcano:</b> ${f.properties.VolcanoName || 'Unnamed'}`)
            }).addTo(map);
            staticLayersLoaded = true;
        } catch (err) { console.error('Static layers error:', err); }
    }

    async function refreshHazards() {
        const syncIcon = document.getElementById('sync-icon');
        const hazardContainer = document.getElementById('hazard-list');
        syncIcon.style.animation = 'spin 1s linear infinite';
        hazardContainer.innerHTML = `<div style="text-align: center; padding: 3rem 1rem; color: var(--text-muted); font-size: 0.85rem;">
            <div class="loading-spinner" style="margin: 0 auto 1rem; width: 24px; height: 24px; border-width: 2px;"></div>
            <div style="font-weight: 500; color: white; margin-bottom: 0.25rem;">Syncing Hazards</div>Analyzing global and local risks...</div>`;
        try {
            const promises = [
                fetch('{{ route("api.disasters.earthquakes") }}').then(r => r.json()),
                fetch('{{ route("api.disasters.events") }}').then(r => r.json())
            ];
            if (!staticLayersLoaded) promises.push(loadStaticLayers());
            const results = await Promise.all(promises);
            earthquakeData = results[0].features || [];
            nasaData = results[1].events || [];
            renderHazardMarkers();
            renderHazardList();
        } catch (err) {
            console.error('Hazard error:', err);
            hazardContainer.innerHTML = '<div style="text-align: center; padding: 2rem; color: #f87171;">Sync failed.</div>';
        } finally { syncIcon.style.animation = 'none'; }
    }

    async function loadEmployees() {
        const loader = document.getElementById('map-loading');
        try {
            const res = await fetch('{{ route("location.index") }}');
            const data = await res.json();
            const uniqueUserIds = new Set(data.map(loc => loc.user_id));
            document.getElementById('total-employees').textContent = uniqueUserIds.size;
            data.forEach(loc => {
                const lat = parseFloat(loc.latitude), lon = parseFloat(loc.longitude);
                if (isNaN(lat) || isNaN(lon)) return;
                const cat = getCategory(loc);
                const marker = L.marker([lat, lon], { icon: getEmployeeIcon(cat) });
                marker.bindPopup(buildEmployeePopup(loc), { maxWidth: 300 });
                employeeMarkers.push({ marker, cat, data: loc });
                marker.addTo(map);
            });
            buildEmployeeFilters();
        } catch (err) { console.error(err); } finally { if (loader) loader.classList.add('hidden'); }
    }

    function getCategory(loc) {
        const type = (loc.employee_type || '').toLowerCase();
        if (type.includes('negros occidental')) return 'NC Negros Occidental';
        if (type.includes('iloilo') || type.includes('ilolo')) return 'NC Ilolo';
        if (type.includes('guimaras')) return 'NC Guimaras';
        if (type.includes('capiz')) return 'NC Capiz';
        if (type.includes('antique')) return 'NC Antique';
        if (type.includes('aklan')) return 'NC AKlan';
        return 'DTI6 Regular Employees';
    }

    function getEmployeeIcon(cat) {
        const color = categories.find(c => c.key === cat)?.color || '#94a3b8';
        const svg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 36" width="28" height="32"><polygon points="16,2 2,16 7,16 7,30 25,30 25,16 30,16" fill="${color}" stroke="#fff" stroke-width="1.5"/><rect x="12" y="20" width="8" height="10" rx="1" fill="#fff" opacity="0.85"/></svg>`;
        return L.divIcon({ html: svg, className: '', iconSize: [28, 32], iconAnchor: [14, 32], popupAnchor: [0, -32] });
    }

    function buildEmployeePopup(loc) {
        const name = loc.user?.name || 'Unknown', color = categories.find(c => c.key === getCategory(loc))?.color || '#94a3b8';
        return `<div style="padding: 10px; min-width: 220px; font-family: 'Outfit', sans-serif;">
            <div style="font-weight: 600; font-size: 1rem; margin-bottom: 2px;">${name}</div>
            <div style="font-size: 0.75rem; color: #94a3b8; margin-bottom: 8px;">${loc.employee_id_no || 'N/A'}</div>
            <div style="display: flex; flex-direction: column; gap: 4px; font-size: 0.85rem;">
                <div><span style="color:#64748b;">Home:</span> ${loc.address || 'N/A'}</div>
                <div><span style="color:#64748b;">Office:</span> ${loc.office || 'Unassigned'}</div>
                <div><span style="color:#64748b;">Mobile:</span> ${loc.mobile_no || '—'}</div>
                <div style="margin-top:6px;">
                    <span style="font-size: 0.7rem; background:${color}22; color:${color}; padding: 2px 8px; border-radius: 4px; font-weight: 600; text-transform: uppercase;">
                        ${loc.employee_type}
                    </span>
                </div>
            </div>
        </div>`;
    }

    function buildEmployeeFilters() {
        const counts = {}; 
        categories.forEach(c => counts[c.key] = new Set()); 
        employeeMarkers.forEach(m => {
            if (counts[m.cat]) counts[m.cat].add(m.data.user_id);
        });
        const container = document.getElementById('employee-filters'); container.innerHTML = '';
        categories.forEach(cat => {
            employeeFilters[cat.key] = true;
            const item = document.createElement('div'); item.className = 'filter-item';
            item.innerHTML = `<input type="checkbox" checked data-key="${cat.key}"><span class="filter-dot" style="background:${cat.color}"></span><span>${cat.label}</span><span class="filter-count">${counts[cat.key].size}</span>`;
            item.onclick = (e) => { const cb = item.querySelector('input'); if (e.target !== cb) cb.checked = !cb.checked; employeeFilters[cat.key] = cb.checked; applyEmployeeFilters(); };
            container.appendChild(item);
        });
    }

    function applyEmployeeFilters() { 
        employeeMarkers.forEach(m => { 
            employeeFilters[m.cat] ? map.addLayer(m.marker) : map.removeLayer(m.marker); 
        }); 
        updateHeaderCount();
    }

    function updateHeaderCount() {
        const visibleMarkers = employeeMarkers.filter(m => map.hasLayer(m.marker));
        const uniqueUserIds = new Set(visibleMarkers.map(m => m.data.user_id));
        const el = document.getElementById('total-employees');
        if (el) el.textContent = uniqueUserIds.size;
    }
    function toggleAllEmployees(state) { Object.keys(employeeFilters).forEach(k => employeeFilters[k] = state); document.querySelectorAll('#employee-filters input').forEach(cb => cb.checked = state); applyEmployeeFilters(); }
    function toggleStaticLayer(type, isFromCheckbox = false) {
        const checkbox = document.getElementById(`layer-${type}`);
        if (!isFromCheckbox) checkbox.checked = !checkbox.checked;
        if (type === 'faults') checkbox.checked ? map.addLayer(faultLayer) : map.removeLayer(faultLayer);
        else checkbox.checked ? map.addLayer(volcanoLayer) : map.removeLayer(volcanoLayer);
    }
    function recenterPH() { map.flyTo([12.8797, 121.7740], 6, { duration: 1.5 }); }

    function renderHazardMarkers() {
        earthquakeMarkers.forEach(m => map.removeLayer(m)); nasaMarkers.forEach(m => map.removeLayer(m));
        earthquakeMarkers = []; nasaMarkers = [];
        if (activeHazardFilter === 'all' || activeHazardFilter === 'earthquake') {
            earthquakeData.forEach(eq => {
                if (!eq.geometry || !eq.geometry.coordinates) return;
                const [lon, lat, depth] = eq.geometry.coordinates, mag = eq.properties.mag, time = new Date(eq.properties.time);
                const marker = L.circleMarker([lat, lon], { radius: Math.max(mag * 3, 5), fillColor: '#fb7185', color: '#f43f5e', weight: 1, opacity: 0.8, fillOpacity: 0.4 }).addTo(map);
                marker.bindPopup(`<div style="min-width: 200px;"><div style="font-weight: 600; color: #f43f5e; margin-bottom: 4px; font-size: 0.95rem;">M ${mag} Earthquake</div><div style="font-size: 0.85rem; margin-bottom: 8px;">${eq.properties.place}</div><div style="display: grid; grid-template-columns: 70px 1fr; gap: 4px; font-size: 0.75rem;"><span style="color: #94a3b8;">Time</span><span>${time.toLocaleString()}</span><span style="color: #94a3b8;">Depth</span><span>${depth ? depth.toFixed(1) + ' km' : 'N/A'}</span></div></div>`);
                earthquakeMarkers.push(marker);
            });
        }
        if (activeHazardFilter === 'all' || activeHazardFilter === 'nasa') {
            nasaData.forEach(event => {
                const geo = event.geometry?.[0]; if (!geo || geo.type !== 'Point') return;
                const [lon, lat] = geo.coordinates;
                const marker = L.circleMarker([lat, lon], { radius: 6, fillColor: '#60a5fa', color: '#3b82f6', weight: 1, opacity: 0.8, fillOpacity: 0.4 }).addTo(map);
                marker.bindPopup(`<div style="min-width: 200px;"><div style="font-weight: 600; color: #3b82f6; margin-bottom: 4px; font-size: 0.95rem;">${event.categories[0]?.title}</div><div style="font-size: 0.85rem; margin-bottom: 8px;">${event.title}</div></div>`);
                nasaMarkers.push(marker);
            });
        }
    }

    function renderHazardList() {
        const container = document.getElementById('hazard-list'); container.innerHTML = '';
        const all = [
            ...(activeHazardFilter === 'all' || activeHazardFilter === 'earthquake' ? earthquakeData.filter(e => e.geometry && e.geometry.coordinates).map(e => ({ type: 'earthquake', title: e.properties.place, mag: e.properties.mag, time: e.properties.time, lat: e.geometry.coordinates[1], lon: e.geometry.coordinates[0] })) : []),
            ...(activeHazardFilter === 'all' || activeHazardFilter === 'nasa' ? nasaData.filter(e => e.geometry && e.geometry[0] && e.geometry[0].coordinates).map(e => ({ type: 'nasa', title: e.title, category: e.categories[0]?.title, time: new Date(e.geometry?.[0]?.date).getTime(), lat: e.geometry?.[0]?.coordinates[1], lon: e.geometry?.[0]?.coordinates[0] })) : [])
        ].sort((a, b) => b.time - a.time);
        if (all.length === 0) { container.innerHTML = '<div style="text-align: center; padding: 2rem; color: var(--text-muted);">No recent hazards.</div>'; return; }
        all.forEach(ev => {
            const card = document.createElement('div'); card.className = 'event-card';
            card.innerHTML = `<div class="badge ${ev.type === 'earthquake' ? 'badge-earthquake' : 'badge-nasa'}">${ev.type === 'earthquake' ? 'Earthquake' : ev.category}</div><div style="font-weight: 600; font-size: 0.85rem;">${ev.type === 'earthquake' ? 'M ' + ev.mag + ' - ' : ''}${ev.title}</div><div class="event-time">${new Date(ev.time).toLocaleString()}</div>`;
            card.onclick = () => { map.flyTo([ev.lat, ev.lon], 10); document.querySelectorAll('.event-card').forEach(c => c.classList.remove('active')); card.classList.add('active'); };
            container.appendChild(card);
        });
    }

    function setHazardFilter(f) {
        activeHazardFilter = f;
        document.querySelectorAll('.sidebar-right .btn-ghost').forEach(b => b.classList.remove('active-hazard-filter', 'btn-primary'));
        const btn = document.getElementById(`h-filter-${f}`);
        if (btn) btn.classList.add('active-hazard-filter');
        renderHazardMarkers(); renderHazardList();
    }

    const searchInput = document.getElementById('employee-search');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase();
            employeeMarkers.forEach(m => {
                const searchStr = `${m.data.user?.name} ${m.data.office}`.toLowerCase();
                const visible = searchStr.includes(query) && employeeFilters[m.cat];
                visible ? map.addLayer(m.marker) : map.removeLayer(m.marker);
            });
        });
    }
</script>
@endsection
