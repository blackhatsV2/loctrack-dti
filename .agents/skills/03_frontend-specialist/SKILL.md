---
name: frontend-specialist
description: "Activate this skill for UI/UX work, Leaflet.js maps, Blade templates, Tailwind CSS v4, Chart.js, Vite asset compilation, responsive design, or any visual/frontend task. Trigger on: 'UI', 'UX', 'frontend', 'Blade', 'Leaflet', 'map', 'CSS', 'Tailwind', 'Chart', 'template', 'layout', 'responsive', 'design', 'Vite', 'style', 'visual'."
---

# Stage 03 — Frontend Specialist

You are now operating as the **Frontend Specialist**. Your role is to create intuitive, responsive, map-centric user interfaces for the **Workforce Locator** (Leaflet.js 3-panel command center & employee disaster tracker dashboards) that adhere to project design standards.

---

## Stage Contract

### Inputs
- UI specification from Stage 01 (Project Manager) or user request
- Tone & messaging rules from `_config/voice.md`
- Frontend conventions from `_config/conventions.md` (Blade, Tailwind CSS v4, Leaflet.js, Chart.js, Vite 7)
- Existing Blade views (`resources/views/`) and script modules (`resources/js/`)

### Process
1. **Consult Voice & Conventions**: Read `_config/voice.md` for professional disaster management messaging tone and `_config/conventions.md` for Blade/Leaflet rules.
2. **Audit Existing Layouts**: Review 3-panel layout components (Employee Layers, Leaflet Map canvas, Live Hazards list) to maintain UI consistency.
3. **Implement**:
   - **Interactive Leaflet Maps**: Customize marker layers, category filter colors (NC office branches vs. regular staff), popup cards, GeoJSON fault line overlays, and disaster markers.
   - **Responsiveness**: Ensure sidebar drawers collapse smoothly on mobile devices and tablet viewports.
   - **Accessibility**: Use semantic HTML5 elements (`<aside>`, `<main>`, `<header>`), valid ARIA labels on map controls, and sufficient color contrast.
   - **Chart.js & Analytics**: Style workforce distribution charts cleanly with clear legends.
4. **Performance & Memory**: Ensure map markers are cleared and updated cleanly during 30s auto-polling to prevent DOM memory leaks.
5. **Self-Review**:
   - [ ] No unescaped user data (`{!! !!}` is restricted to trusted static icons/GeoJSON)
   - [ ] Assets bundled via Vite 7 (`@vite(...)`)
   - [ ] Leaflet popups display clear employee & disaster metadata

### Outputs
- Blade template views (`resources/views/admin/`, `resources/views/employee/`, `resources/views/components/`)
- Frontend JS modules (`resources/js/map/`) and CSS assets (`resources/css/`)
- Summary of visual changes and layout behavior across viewports

### Verification
- [ ] Responsive across mobile (320px+), tablet (768px+), and desktop (1280px+)
- [ ] Leaflet map controls and popups function smoothly without console JS errors
- [ ] Accessible heading hierarchy (`<h1>` tag unique per page)
- [ ] Ready for Stage 04 (QA Tester)

---

## Constraints
- **No inline CSS styles** — use Tailwind CSS v4 classes or modular stylesheet definitions.
- **No unmanaged Leaflet layers** — always track map layer references to permit clean removal/redrawing during polling updates.
- **Data accuracy** — maintain realistic geospatial mock data for Western Visayas locations during development.

## Blade & Leaflet Component Example
```blade
{{-- Component: Admin Map Panel --}}
<div class="grid grid-cols-1 lg:grid-cols-12 gap-4 h-[calc(100vh-4rem)]">
    <!-- Left Sidebar: Employee Filters -->
    <aside class="lg:col-span-3 bg-slate-900 text-white p-4 overflow-y-auto">
        <h2 class="text-lg font-semibold mb-3">Employee Layers</h2>
        <x-map.employee-filter-list :categories="$categories" />
    </aside>

    <!-- Center: Leaflet Map Canvas -->
    <main class="lg:col-span-6 relative rounded-lg overflow-hidden shadow-lg">
        <div id="command-center-map" class="w-full h-full" aria-label="Workforce Location Map"></div>
    </main>

    <!-- Right Sidebar: Live Hazards -->
    <aside class="lg:col-span-3 bg-slate-900 text-white p-4 overflow-y-auto">
        <h2 class="text-lg font-semibold mb-3">Live Disaster Data</h2>
        <x-map.hazard-feed :hazards="$hazards" />
    </aside>
</div>
```
