@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />
<style>
    .address-card-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .address-column {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .address-list {
        max-height: 500px;
        overflow-y: auto;
        border-radius: 0.75rem;
        background: rgba(0, 0, 0, 0.15);
        border: 1px solid var(--glass-border);
    }

    .address-list::-webkit-scrollbar, .table-container::-webkit-scrollbar {
        width: 6px;
    }

    .address-list::-webkit-scrollbar-thumb, .table-container::-webkit-scrollbar-thumb {
        background: rgba(99, 102, 241, 0.3);
        border-radius: 10px;
    }

    .address-item {
        padding: 0.85rem 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        flex-direction: column;
    }

    .address-item:hover {
        background: rgba(99, 102, 241, 0.1);
        padding-left: 1.25rem;
    }

    .address-item.active {
        background: rgba(99, 102, 241, 0.2);
        border-left: 3px solid var(--primary);
    }

    .address-item .emp-name {
        font-weight: 600;
        color: var(--text-light);
        font-size: 0.95rem;
    }

    .address-item .emp-addr {
        font-size: 0.8rem;
        color: var(--text-muted);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .minimap-container {
        height: 500px;
        width: 100%;
        border-radius: 1rem;
        margin-top: 1.5rem;
        border: 1px solid var(--glass-border);
        position: relative;
        z-index: 1;
    }

    .custom-leaflet-icon {
        background: transparent !important;
        border: none !important;
        display: flex !important;
        align-items: center;
        justify-content: center;
        font-family: 'Segoe UI Emoji', 'Apple Color Emoji', 'Noto Color Emoji', sans-serif;
    }

    .map-reset-btn {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 2000;
        background: rgba(15, 23, 42, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        padding: 8px 14px;
        border-radius: 10px;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        backdrop-filter: blur(12px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .map-reset-btn:hover {
        background: var(--primary);
        transform: scale(1.05);
    }

    .filter-select, .search-input {
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid var(--glass-border);
        color: white;
        font-family: 'Outfit', sans-serif;
    }

    .search-input {
        width: 100%;
        margin-bottom: 1rem;
    }

    .search-input:focus, .filter-select:focus {
        outline: none;
        border-color: var(--primary);
    }

    .analytics-grid {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }

    .table-container {
        max-height: 500px;
        overflow-y: auto;
        border-radius: 0.75rem;
        background: rgba(0, 0, 0, 0.1);
        border: 1px solid var(--glass-border);
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th {
        text-align: left;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--glass-border);
        color: var(--text-muted);
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        background: rgba(15, 23, 42, 0.9);
        position: sticky;
        top: 0;
        z-index: 1;
    }

    .data-table td {
        padding: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        font-size: 0.9rem;
    }

    .no-address-section {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--glass-border);
    }

    .tab-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--glass-border);
        color: var(--text-muted);
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .tab-btn.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .workforce-section {
        display: none;
    }

    .workforce-section.active {
        display: block;
    }

    .hidden {
        display: none !important;
    }

    /* Leaflet Popup Styling */
    .leaflet-popup-content-wrapper, .leaflet-popup-tip {
        background: rgba(15, 23, 42, 0.95) !important;
        backdrop-filter: blur(12px);
        color: white !important;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 10px 25px rgba(0,0,0,0.5) !important;
    }

    .leaflet-popup-content {
        margin: 12px 16px !important;
        line-height: 1.4 !important;
    }

    .leaflet-container a.leaflet-popup-close-button {
        color: #94a3b8 !important;
        padding: 8px 8px 0 0 !important;
    }

    @media (max-width: 768px) {
        .address-card-grid, .analytics-grid {
            grid-template-columns: 1fr;
        }
        .minimap-container {
            height: 350px;
        }
    }
</style>
{{-- Leaflet and MarkerCluster are now bundled in app.js via Vite --}}

@endsection

@section('content')
<div class="animate-fade-in">
    <div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 2rem; margin-bottom: 0.5rem;">🌍 Workforce Geography & Analytics</h1>
            <p style="color: var(--text-muted);">Real-time distribution, analytics, and historical records.</p>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <button onclick="switchTab('geography')" class="tab-btn active" id="btn-geography">Geography</button>
            <button onclick="switchTab('analytics')" class="tab-btn" id="btn-analytics">Analytics</button>
            <button onclick="switchTab('records')" class="tab-btn" id="btn-records">Records</button>
        </div>
    </div>

    <!-- Geography Section -->
    <div id="section-geography" class="workforce-section active animate-fade-in">
        <div class="glass-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
                <div style="display: flex; gap: 0.75rem; flex-grow: 1; flex-wrap: wrap;">
                    <input type="text" id="geo-search" class="search-input" style="margin-bottom: 0; max-width: 350px;"
                        placeholder="Search names or addresses..." onkeyup="filterGeoList()">
                    <select id="filter-office" class="filter-select" style="max-width: 200px;" onchange="filterGeoList()">
                        <option value="">All Offices</option>
                        @foreach($allOffices as $office)
                        <option value="{{ $office }}">{{ $office }}</option>
                        @endforeach
                    </select>
                    <select id="filter-type" class="filter-select" style="max-width: 150px;" onchange="filterGeoList()">
                        <option value="">All Types</option>
                        @foreach($employeeTypes as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="address-card-grid">
                <!-- Left: Home Addresses -->
                <div class="address-column">
                    <h4 style="color: var(--primary); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">🏠 Home Addresses</h4>
                    <div class="address-list" id="home-list">
                        @foreach($latestLocations->whereNotNull('address') as $loc)
                        <div class="address-item geo-item" data-user-id="{{ $loc->user_id }}"
                            data-name="{{ strtolower($loc->user->name) }}" data-addr="{{ strtolower($loc->address) }}"
                            data-office="{{ $loc->office }}" data-type="{{ $loc->employee_type }}"
                            onclick="focusOnMap(this, {{ $loc->user_id }}, {{ $loc->latitude }}, {{ $loc->longitude }}, 'home')">
                            <span class="emp-name">{{ $loc->user->name }}</span>
                            <span class="emp-addr" title="{{ $loc->address }}">{{ $loc->address }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Right: Office Addresses -->
                <div class="address-column">
                    <h4 style="color: #f472b6; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">🏢 Office Assignments</h4>
                    <div class="address-list" id="office-list">
                        @foreach($latestLocations->whereNotNull('office') as $loc)
                        <div class="address-item geo-item" data-user-id="{{ $loc->user_id }}"
                            data-name="{{ strtolower($loc->user->name) }}" data-addr="{{ strtolower($loc->office) }}"
                            data-office="{{ $loc->office }}" data-type="{{ $loc->employee_type }}"
                            onclick="focusOnMap(this, {{ $loc->user_id }}, null, null, 'office', '{{ $loc->office }}')">
                            <span class="emp-name">{{ $loc->user->name }}</span>
                            <span class="emp-addr" title="{{ $loc->office }}">{{ $loc->office }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Bottom: Unmapped/No Address Personnel -->
            @php $unmapped = $latestLocations->whereNull('address')->whereNull('office'); @endphp
            @if($unmapped->count() > 0)
            <div class="no-address-section">
                <h4 style="color: #94a3b8; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1rem;">⚠️ Unmapped Personnel</h4>
                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                    @foreach($unmapped as $loc)
                    <div class="glass-card geo-item" data-user-id="{{ $loc->user_id }}"
                        data-name="{{ strtolower($loc->user->name) }}"
                        style="padding: 0.5rem 0.75rem; font-size: 0.85rem; background: rgba(244, 63, 94, 0.1); border-color: rgba(244, 63, 94, 0.2);">
                        {{ $loc->user->name }}
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Minimap -->
            <div class="minimap-wrapper" style="position: relative; margin-top: 1.5rem;">
                <div id="minimap" class="minimap-container" style="margin-top: 0;"></div>
                <button onclick="resetMinimap()" class="map-reset-btn">
                    <span>🔄</span> Show All
                </button>
            </div>
        </div>
    </div>

    <!-- Analytics Section -->
    <div id="section-analytics" class="workforce-section animate-fade-in">
        <div class="analytics-grid">
            <div class="glass-card">
                <h3 style="margin-bottom: 1.5rem; font-size: 1.1rem; color: var(--text-light);">Office Distribution</h3>
                <div class="chart-container">
                    <div class="page-loading" id="office-chart-loading">
                        <div class="skeleton" style="width: 200px; height: 200px; border-radius: 50%;"></div>
                        <div class="skeleton" style="width: 140px; height: 12px; margin-top: 1rem;"></div>
                    </div>
                    <canvas id="officeChart"></canvas>
                </div>
            </div>
            <div class="glass-card">
                <h3 style="margin-bottom: 1.5rem; font-size: 1.1rem; color: var(--text-light);">Personnel Type Breakdown</h3>
                <div class="chart-container">
                    <div class="page-loading" id="type-chart-loading">
                        <div style="display: flex; align-items: flex-end; gap: 8px; height: 150px; width: 100%; padding: 0 20px;">
                            <div class="skeleton" style="flex: 1; height: 60%;"></div>
                            <div class="skeleton" style="flex: 1; height: 90%;"></div>
                            <div class="skeleton" style="flex: 1; height: 40%;"></div>
                            <div class="skeleton" style="flex: 1; height: 75%;"></div>
                            <div class="skeleton" style="flex: 1; height: 55%;"></div>
                        </div>
                        <div class="skeleton" style="width: 140px; height: 12px; margin-top: 1rem;"></div>
                    </div>
                    <canvas id="typeChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Office Table -->
        <div class="glass-card">
            <h2 style="margin-bottom: 1.5rem;">🏢 Office Locations Details</h2>
            <input type="text" id="office-search" class="search-input" placeholder="Search offices..."
                onkeyup="powerSearch('office-table', 'office-search')">
            <div class="table-container">
                <table class="data-table" id="office-table">
                    <thead>
                        <tr>
                            <th>Office Name</th>
                            <th>Coordinates</th>
                            <th>Active Personnel</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($offices as $office)
                        <tr class="search-row">
                            <td class="searchable">{{ $office }}</td>
                            <td>
                                @php $officeLoc = $latestLocations->where('office', $office)->first(); @endphp
                                {{ $officeLoc ? round($officeLoc->latitude, 4) . ', ' . round($officeLoc->longitude, 4) : 'N/A' }}
                            </td>
                            <td>{{ $latestLocations->where('office', $office)->count() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Records Section -->
    <div id="section-records" class="workforce-section animate-fade-in">
        <div class="glass-card">
            <h2 style="margin-bottom: 1.5rem;">📍 Recent Location Records</h2>
            <input type="text" id="power-search" class="search-input"
                placeholder="Power Search: Find by name, address, or office..."
                onkeyup="powerSearch('location-table', 'power-search')">
            <div class="table-container" style="position: relative;">
                <div class="page-loading" id="table-loading" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 10; background: rgba(15, 23, 42, 0.9); flex-direction: column; gap: 0.75rem; padding: 2rem;">
                    <div class="skeleton" style="width: 100%; height: 40px;"></div>
                    <div class="skeleton" style="width: 100%; height: 40px; opacity: 0.8;"></div>
                    <div class="skeleton" style="width: 100%; height: 40px; opacity: 0.6;"></div>
                    <div class="skeleton" style="width: 100%; height: 40px; opacity: 0.4;"></div>
                    <div class="skeleton" style="width: 100%; height: 40px; opacity: 0.2;"></div>
                </div>
                <table class="data-table" id="location-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Office</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentLocations as $loc)
                        <tr class="search-row">
                            <td class="searchable">{{ $loc->user->name }}</td>
                            <td class="searchable" style="max-width: 300px;">{{ $loc->address ?? 'GPS Check-in' }}</td>
                            <td class="searchable">{{ $loc->office ?? $loc->user->office ?? 'N/A' }}</td>
                            <td>{{ $loc->recorded_at->format('M d, Y h:i A') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{-- Libraries are also bundled in app.js --}}

<script>
    // --- Tabs Logic ---
    function switchTab(tabId) {
        document.querySelectorAll('.workforce-section').forEach(s => s.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        
        document.getElementById('section-' + tabId).classList.add('active');
        document.getElementById('btn-' + tabId).classList.add('active');
        
        if (tabId === 'geography' && minimap) {
            setTimeout(() => minimap.invalidateSize(), 100);
        }
    }

    // --- Charts Logic ---
    const hideLoading = () => {
        document.getElementById('office-chart-loading')?.classList.add('hidden');
        document.getElementById('type-chart-loading')?.classList.add('hidden');
        document.getElementById('table-loading')?.classList.add('hidden');
    };

    function initCharts() {
        try {
            const officeData = @json($officeDistribution);
            const typeData = @json($typeDistribution);

            const chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#94a3b8', font: { family: 'Outfit', size: 12 }, usePointStyle: true }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleFont: { family: 'Outfit' },
                        bodyFont: { family: 'Outfit' }
                    }
                }
            };

            if (Object.keys(officeData).length > 0) {
                new Chart(document.getElementById('officeChart'), {
                    type: 'doughnut',
                    data: {
                        labels: Object.keys(officeData),
                        datasets: [{
                            data: Object.values(officeData),
                            backgroundColor: ['#6366f1', '#10b981', '#3b82f6', '#8b5cf6', '#f43f5e', '#f59e0b', '#06b6d4'],
                            borderWidth: 2, borderColor: '#1e293b'
                        }]
                    },
                    options: { ...chartOptions, cutout: '75%', spacing: 5 }
                });
            }

            if (Object.keys(typeData).length > 0) {
                const ctx = document.getElementById('typeChart').getContext('2d');
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(99, 102, 241, 0.8)');
                gradient.addColorStop(1, 'rgba(99, 102, 241, 0.1)');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(typeData),
                        datasets: [{
                            label: 'Personnel Count',
                            data: Object.values(typeData),
                            backgroundColor: gradient,
                            borderColor: '#818cf8',
                            borderWidth: 2, borderRadius: 8
                        }]
                    },
                    options: {
                        ...chartOptions,
                        scales: {
                            y: { beginAtZero: true, grid: { color: 'rgba(255, 255, 255, 0.05)' }, ticks: { color: '#94a3b8' } },
                            x: { grid: { display: false }, ticks: { color: '#94a3b8' } }
                        },
                        plugins: { ...chartOptions.plugins, legend: { display: false } }
                    }
                });
            }
            hideLoading();
        } catch (e) {
            console.error('Charts failed:', e);
            hideLoading();
        }
    }

    // --- Geography Logic ---
    let minimap, markerCluster;
    const employeeMarkers = {};
    const allLocations = @json($latestLocations);

    const officeMapping = {
        'regional office': [10.7202, 122.5621], 'iloilo': [10.7202, 122.5621],
        'negros occidental': [10.6765, 122.9509], 'bacolod': [10.6765, 122.9509],
        'aklan': [11.7104, 122.3666], 'kalibo': [11.7104, 122.3666],
        'antique': [10.7410, 121.9442], 'san jose': [10.7410, 121.9442],
        'capiz': [11.5853, 122.7511], 'roxas city': [11.5853, 122.7511],
        'guimaras': [10.5925, 122.5878], 'jordan': [10.5925, 122.5878]
    };

    function getOfficeCoords(officeName) {
        if (!officeName) return [10.7202, 122.5621];
        const lower = officeName.toLowerCase();
        for (const [key, coords] of Object.entries(officeMapping)) {
            if (lower.includes(key)) return coords;
        }
        return [10.7202, 122.5621];
    }

    function createCustomIcon(emoji) {
        return L.divIcon({
            html: `<div style="font-size: 24px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));">${emoji}</div>`,
            className: 'custom-leaflet-icon',
            iconSize: [30, 30],
            iconAnchor: [15, 15],
            popupAnchor: [0, -15]
        });
    }

    function initMinimap() {
        try {
            minimap = L.map('minimap', { scrollWheelZoom: false }).setView([10.7202, 122.5621], 9);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(minimap);
            resetMinimap();
        } catch (e) { console.error('Map failed:', e); }
    }

    function resetMinimap() {
        if (!minimap) return;
        syncMapMarkers(new Set(allLocations.map(loc => loc.user_id.toString())));
        minimap.setView([10.7202, 122.5621], 9);
        document.querySelectorAll('.address-item').forEach(el => el.classList.remove('active'));
    }

    function syncMapMarkers(userIds) {
        if (!minimap) return;
        if (markerCluster) minimap.removeLayer(markerCluster);
        markerCluster = L.markerClusterGroup({ showCoverageOnHover: false, disableClusteringAtZoom: 16 });

        allLocations.forEach(loc => {
            if (!userIds.has(loc.user_id.toString())) return;
            const isHome = loc.address != null;
            const coords = isHome ? [loc.latitude, loc.longitude] : getOfficeCoords(loc.office);
            const label = isHome ? 'Home Address' : 'Office Assignment';
            const addressText = isHome ? loc.address : loc.office;
            
            const marker = L.marker(coords, { icon: createCustomIcon(isHome ? '🏠' : '🏢') });
            
            marker.bindPopup(`
                <div style="font-family: 'Outfit', sans-serif; min-width: 150px;">
                    <strong style="display: block; font-size: 1rem; margin-bottom: 4px; color: var(--primary);">${loc.user.name}</strong>
                    <div style="font-weight: 600; font-size: 0.8rem; text-transform: uppercase; color: #94a3b8; margin-bottom: 4px;">${label}</div>
                    <div style="font-size: 0.85rem; color: #f8fafc;">${addressText}</div>
                </div>
            `);
            
            markerCluster.addLayer(marker);
            employeeMarkers[loc.user_id] = marker;
        });
        minimap.addLayer(markerCluster);
    }

    function focusOnMap(clickedEl, userId, lat, lng, type, officeName) {
        // 1. Sync highlighting across both lists
        document.querySelectorAll('.address-item').forEach(el => el.classList.remove('active'));
        
        const matchingItems = document.querySelectorAll(`.address-item[data-user-id="${userId}"]`);
        
        let relativeOffset = 0;
        if (clickedEl) {
            const container = clickedEl.closest('.address-list');
            if (container) {
                relativeOffset = clickedEl.offsetTop - container.scrollTop;
            }
        }

        matchingItems.forEach(el => {
            el.classList.add('active');
            
            // 2. Relative Sync scrolling
            if (el !== clickedEl) {
                const otherContainer = el.closest('.address-list');
                if (otherContainer) {
                    otherContainer.scrollTo({
                        top: el.offsetTop - relativeOffset,
                        behavior: 'smooth'
                    });
                }
            }
        });

        // 3. Map focus - Show prominent solo marker
        if (minimap) {
            // Clear existing marker cluster to focus on selection
            if (markerCluster) minimap.removeLayer(markerCluster);

            const coords = type === 'home' ? [lat, lng] : getOfficeCoords(officeName);
            const iconEmoji = type === 'home' ? '🏠' : '🏢';
            const label = type === 'home' ? 'Home Address' : 'Office Assignment';
            const addressText = type === 'home' ? (clickedEl.querySelector('.emp-addr').title) : officeName;
            
            const emp = allLocations.find(l => l.user_id == userId);
            const name = emp ? emp.user.name : 'Employee';

            const focusMarker = L.marker(coords, { 
                icon: createCustomIcon(iconEmoji),
                zIndexOffset: 1000 
            })
            .addTo(minimap)
            .bindPopup(`
                <div style="font-family: 'Outfit', sans-serif; min-width: 150px;">
                    <strong style="display: block; font-size: 1rem; margin-bottom: 4px; color: var(--primary);">${name}</strong>
                    <div style="font-weight: 600; font-size: 0.8rem; text-transform: uppercase; color: #94a3b8; margin-bottom: 4px;">${label}</div>
                    <div style="font-size: 0.85rem; color: #f8fafc;">${addressText}</div>
                </div>
            `)
            .openPopup();

            // Wrap in a LayerGroup so resetMinimap can clear it easily
            markerCluster = L.layerGroup([focusMarker]).addTo(minimap);
            
            minimap.setView(coords, 16, { animate: true });

            // Show indicator if map is out of view
            showMapHint();
        }
    }

    function showMapHint() {
        const mapEl = document.getElementById('minimap');
        if (!mapEl) return;

        const rect = mapEl.getBoundingClientRect();
        const isInViewport = (
            rect.top >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight)
        );

        if (!isInViewport) {
            let hint = document.getElementById('map-scroll-hint');
            if (hint) hint.remove(); // Reset existing hint

            hint = document.createElement('div');
            hint.id = 'map-scroll-hint';
            hint.innerHTML = `
                <div style="background: var(--primary); color: white; padding: 0.85rem 1.5rem; border-radius: 1.25rem; display: flex; align-items: center; gap: 0.75rem; box-shadow: 0 15px 35px rgba(0,0,0,0.5); cursor: pointer; backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.2);" 
                     onclick="document.getElementById('minimap').scrollIntoView({behavior: 'smooth', block: 'center'}); this.parentElement.remove();">
                    <span style="font-size: 1.2rem;">📍</span>
                    <div>
                        <div style="font-weight: 600; font-size: 0.95rem;">Map Updated Below</div>
                        <div style="font-size: 0.75rem; opacity: 0.9;">Click to scroll to location</div>
                    </div>
                </div>
            `;
            hint.style.position = 'fixed';
            hint.style.bottom = '2.5rem';
            hint.style.left = '50%';
            hint.style.transform = 'translateX(-50%)';
            hint.style.zIndex = '10000';
            hint.style.transition = 'all 0.3s ease';
            hint.className = 'animate-fade-in';
            document.body.appendChild(hint);

            // Auto-hide after 5 seconds
            clearTimeout(window.mapHintTimeout);
            window.mapHintTimeout = setTimeout(() => {
                if (hint && hint.parentElement) {
                    hint.style.opacity = '0';
                    hint.style.transform = 'translateX(-50%) translateY(10px)';
                    setTimeout(() => hint.remove(), 300);
                }
            }, 5000);
        }
    }

    function filterGeoList() {
        const search = document.getElementById('geo-search').value.toLowerCase();
        const officeFilter = document.getElementById('filter-office').value;
        const typeFilter = document.getElementById('filter-type').value;
        const visibleIds = new Set();

        document.querySelectorAll('.geo-item').forEach(item => {
            const matches = item.dataset.name.includes(search) && 
                            (officeFilter === '' || item.dataset.office === officeFilter) &&
                            (typeFilter === '' || item.dataset.type === typeFilter);
            item.style.display = matches ? '' : 'none';
            if (matches) visibleIds.add(item.dataset.userId);
        });
        syncMapMarkers(visibleIds);
    }

    // --- Search Logic ---
    function powerSearch(tableId, inputId) {
        const filter = document.getElementById(inputId).value.toLowerCase();
        document.querySelectorAll(`#${tableId} .search-row`).forEach(row => {
            const text = Array.from(row.querySelectorAll('.searchable')).map(td => td.textContent.toLowerCase()).join(' ');
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        try { initCharts(); } catch (e) { console.error('Charts init failed:', e); }
        try { initMinimap(); } catch (e) { console.error('Minimap init failed:', e); }

        // Handle initial tab from URL hash
        const hash = window.location.hash.replace('#', '');
        if (['geography', 'analytics', 'records'].includes(hash)) {
            switchTab(hash);
        }
    });
</script>
@endsection
