@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    :root {
        --sidebar-left: 300px;
        --sidebar-right: 360px;
    }

    .unified-layout {
        display: flex;
        height: calc(100vh - 140px);
        min-height: 700px;
        background: #0f172a;
        border-radius: 1.5rem;
        overflow: hidden;
        border: 1px solid var(--glass-border);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    /* Left Sidebar: Employees/Layers */
    .sidebar-left {
        width: var(--sidebar-left);
        min-width: var(--sidebar-left);
        background: var(--glass);
        backdrop-filter: blur(12px);
        border-right: 1px solid var(--glass-border);
        display: flex;
        flex-direction: column;
        z-index: 10;
    }

    /* Right Sidebar: Hazards */
    .sidebar-right {
        width: var(--sidebar-right);
        min-width: var(--sidebar-right);
        background: var(--glass);
        backdrop-filter: blur(12px);
        border-left: 1px solid var(--glass-border);
        display: flex;
        flex-direction: column;
        z-index: 10;
    }

    .map-container {
        flex: 1;
        position: relative;
        background: #111;
    }

    #unified-map {
        width: 100%;
        height: 100%;
    }

    /* Sidebar Components */
    .sidebar-header {
        padding: 1.25rem;
        border-bottom: 1px solid var(--glass-border);
    }
    .sidebar-header h3 { font-size: 1rem; font-weight: 600; margin-bottom: 0.25rem; display: flex; align-items: center; gap: 0.5rem; }
    
    .scroll-content {
        flex: 1;
        overflow-y: auto;
    }
    .scroll-content::-webkit-scrollbar { width: 4px; }
    .scroll-content::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 2px; }

    .filter-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1.25rem;
        cursor: pointer;
        transition: background 0.2s;
        font-size: 0.85rem;
    }
    .filter-item:hover { background: rgba(255,255,255,0.03); }
    .filter-item input[type="checkbox"] { accent-color: var(--primary); width: 16px; height: 16px; }
    
    .hazard-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--glass-border);
        border-radius: 0.75rem;
        padding: 1rem;
        margin: 0.5rem 1rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    .hazard-card:hover { border-color: var(--primary); background: rgba(99, 102, 241, 0.05); }
    .hazard-card.active { border-color: var(--primary); background: rgba(99, 102, 241, 0.1); }

    .badge {
        padding: 0.2rem 0.5rem;
        border-radius: 0.4rem;
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
        display: inline-block;
    }
    .badge-earthquake { background: rgba(244, 63, 94, 0.2); color: #fb7185; }
    .badge-nasa { background: rgba(59, 130, 246, 0.2); color: #60a5fa; }

    .search-box {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--glass-border);
    }
    .search-input {
        width: 100%;
        background: rgba(0,0,0,0.2);
        border: 1px solid var(--glass-border);
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
        color: white;
        font-size: 0.85rem;
    }

    .loading-overlay {
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, 0.9);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        z-index: 2000;
        gap: 1rem;
        transition: opacity 0.5s ease;
    }
    .loading-overlay.hidden { 
        opacity: 0; 
        pointer-events: none; 
    }

    @media (max-width: 1280px) {
        .sidebar-right { width: 300px; min-width: 300px; }
    }
    @media (max-width: 1024px) {
        .sidebar-right { display: none; }
    }
    @media (max-width: 768px) {
        .sidebar-left { display: none; }
    }
</style>
@endsection

@section('content')
<div class="animate-fade-in">
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1.5rem;">
        <div>
            <h1 style="font-size: 1.75rem; margin-bottom: 0.25rem;">Unified Disaster & Workforce Map</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Integrated monitoring of personnel safety and global hazards</p>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <button onclick="syncData()" class="btn btn-ghost" style="font-size: 0.8rem;">
                <span id="sync-icon">🔄</span> Sync Data
            </button>
            <button onclick="recenterPH()" class="btn btn-primary" style="font-size: 0.8rem;">
                📍 Recenter PH
            </button>
        </div>
    </div>

    <div class="unified-layout">
        <!-- Personnel Side -->
        <aside class="sidebar-left">
            <div class="sidebar-header">
                <h3>👥 Personnel Layers</h3>
                <small>Showing <span id="emp-visible-count">0</span> employees</small>
            </div>
            <div class="search-box">
                <input type="text" id="emp-search" class="search-input" placeholder="Search name or office...">
            </div>
            <div class="scroll-content" id="employee-layers">
                <!-- Dynamic categories -->
            </div>
            <div style="padding: 1.25rem; border-top: 1px solid var(--glass-border); display: flex; gap: 0.5rem;">
                <button class="btn btn-ghost" style="flex: 1; font-size: 0.75rem; padding: 0.5rem;" onclick="setAllEmployees(false)">Hide All</button>
                <button class="btn btn-primary" style="flex: 1; font-size: 0.75rem; padding: 0.5rem;" onclick="setAllEmployees(true)">Show All</button>
            </div>
        </aside>

        <!-- Central Map -->
        <div class="map-container">
            <div id="unified-map"></div>
            <div class="loading-overlay" id="map-loader">
                <div class="spinner"></div>
                <div style="color: var(--text-muted); font-size: 0.9rem;">Loading map data...</div>
            </div>
        </div>

        <!-- Hazard Side -->
        <aside class="sidebar-right">
            <div class="sidebar-header">
                <h3>⚠️ Hazard Monitoring</h3>
                <div style="display: flex; gap: 0.5rem; margin-top: 0.75rem;">
                    <button onclick="setHazardType('all')" class="btn btn-ghost hazard-pill active" id="hp-all" style="padding: 0.25rem 0.6rem; font-size: 0.7rem;">All</button>
                    <button onclick="setHazardType('earthquake')" class="btn btn-ghost hazard-pill" id="hp-earthquake" style="padding: 0.25rem 0.6rem; font-size: 0.7rem;">USGS</button>
                    <button onclick="setHazardType('nasa')" class="btn btn-ghost hazard-pill" id="hp-nasa" style="padding: 0.25rem 0.6rem; font-size: 0.7rem;">NASA</button>
                </div>
            </div>
            <div class="scroll-content" id="hazard-scroll">
                <!-- Hazards list -->
            </div>
            <div style="padding: 1.25rem; border-top: 1px solid var(--glass-border);">
                <div style="font-size: 0.7rem; font-weight: 600; color: var(--text-muted); margin-bottom: 0.75rem; text-transform: uppercase;">Static Overlays</div>
                <div class="filter-item" onclick="toggleOverlay('faults')">
                    <input type="checkbox" id="check-faults" checked onclick="event.stopPropagation(); toggleOverlay('faults', true)">
                    <span style="display:inline-block; width:12px; height:2px; background:#f87171;"></span>
                    <span>Active Faults</span>
                </div>
                <div class="filter-item" onclick="toggleOverlay('volcanoes')">
                    <input type="checkbox" id="check-volcanoes" checked onclick="event.stopPropagation(); toggleOverlay('volcanoes', true)">
                    <span style="display:inline-block; width:10px; height:10px; border-radius:50%; background:#fbbf24; border:1px solid #d97706;"></span>
                    <span>Volcanoes</span>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let map;
    let empMarkers = [];
    let eqMarkers = [];
    let nasaMarkers = [];
    let earthquakeData = [];
    let nasaData = [];
    let faultsLayer, volcanoesLayer;
    let staticLayersLoaded = false;
    let activeHazardType = 'all';
    let employeeFilters = {};

    const empCategories = [
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
        loadPersonnel();
        syncHazards();
    });

    function initMap() {
        map = L.map('unified-map', { zoomControl: false, attributionControl: false, preferCanvas: true })
            .setView([12.8797, 121.7740], 6);

        const dark = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', { maxZoom: 19 }).addTo(map);
        const satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}');
        
        L.control.layers({ "Dark Mode": dark, "Satellite": satellite }, {}, { position: 'topleft' }).addTo(map);
        L.control.zoom({ position: 'bottomright' }).addTo(map);
    }

    async function loadStaticLayers() {
        try {
            const [fRes, vRes] = await Promise.all([
                fetch('/maps/ph_faults.json').then(r => r.json()),
                fetch('/maps/ph_volcanoes.json').then(r => r.json())
            ]);

            faultsLayer = L.geoJSON(fRes, {
                style: { color: '#f87171', weight: 2, opacity: 0.8, dashArray: '5, 5' },
                onEachFeature: (f, l) => l.bindPopup(`<b>Fault:</b> ${f.properties.name || 'Unnamed'}`)
            }).addTo(map);

            volcanoesLayer = L.geoJSON(vRes, {
                pointToLayer: (f, latlng) => L.circleMarker(latlng, { radius: 6, fillColor: '#fbbf24', color: '#d97706', weight: 1.5, opacity: 1, fillOpacity: 0.8 }),
                onEachFeature: (f, l) => l.bindPopup(`<b>Volcano:</b> ${f.properties.VolcanoName || 'Unnamed'}`)
            }).addTo(map);
            
            staticLayersLoaded = true;
        } catch (err) {
            console.error('Static layers load error:', err);
        }
    }

    function toggleOverlay(type, isFromCheckbox = false) {
        const check = document.getElementById(`check-${type}`);
        if (!isFromCheckbox) check.checked = !check.checked;
        
        if (type === 'faults') check.checked ? map.addLayer(faultsLayer) : map.removeLayer(faultsLayer);
        else check.checked ? map.addLayer(volcanoesLayer) : map.removeLayer(volcanoesLayer);
    }

    function recenterPH() { map.flyTo([12.8797, 121.7740], 6, { duration: 1.5 }); }

    // Personnel Logic
    async function loadPersonnel() {
        const loader = document.getElementById('map-loader');
        try {
            const res = await fetch('{{ route("location.index") }}');
            const data = await res.json();
            
            data.forEach(loc => {
                const lat = parseFloat(loc.latitude);
                const lon = parseFloat(loc.longitude);
                if (isNaN(lat) || isNaN(lon)) return;

                const cat = getEmpCat(loc);
                const marker = L.marker([lat, lon], { icon: getEmpIcon(cat) });
                marker.bindPopup(buildEmpPopup(loc), { maxWidth: 300 });
                empMarkers.push({ marker, cat, data: loc });
                marker.addTo(map);
            });

            renderEmpLayers();
            updateEmpCount();
        } catch (err) {
            console.error('Personnel load error:', err);
        } finally {
            if (loader) loader.classList.add('hidden');
        }
    }

    function getEmpCat(loc) {
        const t = (loc.employee_type || '').toLowerCase();
        if (t.includes('negros occidental')) return 'NC Negros Occidental';
        if (t.includes('iloilo') || t.includes('ilolo')) return 'NC Ilolo';
        if (t.includes('guimaras')) return 'NC Guimaras';
        if (t.includes('capiz')) return 'NC Capiz';
        if (t.includes('antique')) return 'NC Antique';
        if (t.includes('aklan')) return 'NC AKlan';
        return 'DTI6 Regular Employees';
    }

    function getEmpIcon(cat) {
        const color = empCategories.find(c => c.key === cat)?.color || '#94a3b8';
        const svg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 36" width="28" height="32">
            <polygon points="16,2 2,16 7,16 7,30 25,30 25,16 30,16" fill="${color}" stroke="#fff" stroke-width="1.5"/>
            <rect x="12" y="20" width="8" height="10" rx="1" fill="#fff" opacity="0.85"/>
        </svg>`;
        return L.divIcon({ html: svg, className: '', iconSize: [28, 32], iconAnchor: [14, 32] });
    }

    function buildEmpPopup(loc) {
        return `<div style="padding: 10px; min-width: 200px;">
            <div style="font-weight: 600; font-size: 1rem;">${loc.user?.name}</div>
            <div style="font-size: 0.8rem; color: #94a3b8; margin-bottom: 8px;">${loc.employee_id_no || 'N/A'}</div>
            <div style="font-size: 0.85rem;"><b>Office:</b> ${loc.office || 'N/A'}</div>
            <div style="font-size: 0.85rem;"><b>Mobile:</b> ${loc.mobile_no || '—'}</div>
        </div>`;
    }

    function renderEmpLayers() {
        const container = document.getElementById('employee-layers');
        container.innerHTML = '';
        empCategories.forEach(cat => {
            employeeFilters[cat.key] = true;
            const count = empMarkers.filter(m => m.cat === cat.key).length;
            const item = document.createElement('div');
            item.className = 'filter-item';
            item.innerHTML = `<input type="checkbox" checked data-key="${cat.key}">
                <span style="width:10px; height:10px; border-radius:50%; background:${cat.color}"></span>
                <span style="flex:1;">${cat.label}</span><span style="font-size:0.7rem; opacity:0.6;">${count}</span>`;
            item.onclick = (e) => {
                const cb = item.querySelector('input');
                if (e.target !== cb) cb.checked = !cb.checked;
                employeeFilters[cat.key] = cb.checked;
                applyEmpFilters();
            };
            container.appendChild(item);
        });
    }

    function applyEmpFilters() {
        empMarkers.forEach(m => {
            employeeFilters[m.cat] ? map.addLayer(m.marker) : map.removeLayer(m.marker);
        });
        updateEmpCount();
    }

    function updateEmpCount() {
        document.getElementById('emp-visible-count').textContent = empMarkers.filter(m => map.hasLayer(m.marker)).length;
    }

    function setAllEmployees(s) {
        Object.keys(employeeFilters).forEach(k => employeeFilters[k] = s);
        document.querySelectorAll('#employee-layers input').forEach(cb => cb.checked = s);
        applyEmpFilters();
    }

    // Hazard Logic
    async function syncHazards() {
        const icon = document.getElementById('sync-icon');
        const hazardContainer = document.getElementById('hazard-scroll');
        icon.style.animation = 'spin 1s linear infinite';
        
        hazardContainer.innerHTML = `
            <div style="text-align: center; padding: 3rem 1rem; color: var(--text-muted); font-size: 0.85rem;">
                <div class="spinner" style="margin: 0 auto 1rem; width: 24px; height: 24px; border-width: 2px;"></div>
                <div style="font-weight: 500; color: white; margin-bottom: 0.25rem;">Syncing Hazards</div>
                Analyzing global and local risks...
            </div>
        `;

        try {
            const hazardPromises = [
                fetch('{{ route("api.disasters.earthquakes") }}').then(r => r.json()),
                fetch('{{ route("api.disasters.events") }}').then(r => r.json())
            ];
            
            if (!staticLayersLoaded) {
                hazardPromises.push(loadStaticLayers());
            }

            const results = await Promise.all(hazardPromises);
            
            earthquakeData = results[0].features || [];
            nasaData = results[1].events || [];

            renderHazMarkers();
            renderHazList();
        } catch (err) {
            console.error('Hazard sync error:', err);
            hazardContainer.innerHTML = '<div style="text-align: center; padding: 2rem; color: #f87171;">Failed to sync hazards.</div>';
        } finally { 
            icon.style.animation = 'none'; 
        }
    }

    function renderHazMarkers() {
        eqMarkers.forEach(m => map.removeLayer(m));
        nasaMarkers.forEach(m => map.removeLayer(m));
        eqMarkers = []; nasaMarkers = [];

        if (activeHazardType === 'all' || activeHazardType === 'earthquake') {
            earthquakeData.forEach(e => {
                if (!e.geometry || !e.geometry.coordinates) return;
                const [lon, lat, depth] = e.geometry.coordinates;
                const m = L.circleMarker([lat, lon], { radius: Math.max(e.properties.mag * 3, 5), fillColor: '#fb7185', color: '#f43f5e', weight: 1, fillOpacity: 0.4 }).addTo(map);
                m.bindPopup(`<b>M ${e.properties.mag} Earthquake</b><br>${e.properties.place}<br><small>Depth: ${depth}km</small>`);
                eqMarkers.push(m);
            });
        }
        if (activeHazardType === 'all' || activeHazardType === 'nasa') {
            nasaData.forEach(e => {
                const geo = e.geometry?.[0]; if (!geo) return;
                const [lon, lat] = geo.coordinates;
                const m = L.circleMarker([lat, lon], { radius: 6, fillColor: '#60a5fa', color: '#3b82f6', weight: 1, fillOpacity: 0.4 }).addTo(map);
                m.bindPopup(`<b>${e.categories[0]?.title}</b><br>${e.title}`);
                nasaMarkers.push(m);
            });
        }
    }

    function renderHazList() {
        const container = document.getElementById('hazard-scroll');
        container.innerHTML = '';
        const all = [
            ...(activeHazardType === 'all' || activeHazardType === 'earthquake' ? earthquakeData.filter(e => e.geometry && e.geometry.coordinates).map(e => ({ type: 'earthquake', title: e.properties.place, mag: e.properties.mag, time: e.properties.time, lat: e.geometry.coordinates[1], lon: e.geometry.coordinates[0] })) : []),
            ...(activeHazardType === 'all' || activeHazardType === 'nasa' ? nasaData.filter(e => e.geometry && e.geometry[0] && e.geometry[0].coordinates).map(e => ({ type: 'nasa', title: e.title, category: e.categories[0]?.title, time: new Date(e.geometry?.[0]?.date).getTime(), lat: e.geometry?.[0]?.coordinates[1], lon: e.geometry?.[0]?.coordinates[0] })) : [])
        ].sort((a, b) => b.time - a.time);

        all.forEach(h => {
            const card = document.createElement('div');
            card.className = 'hazard-card';
            card.innerHTML = `<div class="badge ${h.type === 'earthquake' ? 'badge-earthquake' : 'badge-nasa'}">${h.type === 'earthquake' ? 'Earthquake' : h.category}</div>
                <div style="font-weight: 600; font-size: 0.85rem;">${h.type === 'earthquake' ? 'M ' + h.mag + ' - ' : ''}${h.title}</div>
                <div style="font-size: 0.7rem; opacity: 0.6; margin-top: 4px;">${new Date(h.time).toLocaleString()}</div>`;
            card.onclick = () => {
                map.flyTo([h.lat, h.lon], 10);
                document.querySelectorAll('.hazard-card').forEach(c => c.classList.remove('active'));
                card.classList.add('active');
            };
            container.appendChild(card);
        });
    }

    function setHazardType(t) {
        activeHazardType = t;
        document.querySelectorAll('.hazard-pill').forEach(b => b.classList.remove('active'));
        document.getElementById(`hp-${t}`).classList.add('active');
        renderHazMarkers(); renderHazList();
    }

    // Search
    document.getElementById('emp-search').addEventListener('input', (e) => {
        const q = e.target.value.toLowerCase();
        empMarkers.forEach(m => {
            const s = `${m.data.user?.name} ${m.data.office}`.toLowerCase();
            const v = s.includes(q) && employeeFilters[m.cat];
            v ? map.addLayer(m.marker) : map.removeLayer(m.marker);
        });
        updateEmpCount();
    });

    function syncData() { syncHazards(); loadPersonnel(); }
</script>
@endsection
