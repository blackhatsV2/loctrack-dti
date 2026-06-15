[← Back to README](README.md) | [← Previous: Presentation](9_Presentation.md) | [Next: Project Modules →](11_Project_Modules.md)

# Master Project Plan: Preparedness, Safety & Continuity Portal: Workforce Locator

---

## 1. Project Summary
The Workforce Locator is a web-based monitoring platform for DTI Region 6 that maps employee locations alongside live disaster data. It provides administrators with a unified command center for workforce visibility and hazard awareness.

---

## 2. Implemented Features

### Phase 1: Core Telemetry & Employee Management
- [x] GPS coordinate capture via browser Geolocation API (`/api/location`).
- [x] Location broadcast endpoint (`/api/broadcast`).
- [x] Location reuse from history (`/api/location/reuse/{id}`).
- [x] Employee self-service profile and address management (`/geography`, `/profile/update`, `/profile/password`).
- [x] Employee location history with pagination (`/history`).
- [x] Authentication via email or full name with role-based redirect.
- [x] Admin employee directory with full CRUD (add via modal, edit page, delete with confirmation).
- [x] Real-time client-side employee search and office filtering on the directory page.
- [x] Admin location history auditing with individual delete, bulk delete, and clear-all.
- [x] Online personnel tracking with 30-second auto-refresh (active in last 24 hours).
- [x] Carried-forward metadata on each location submission.

### Phase 2: Disaster Integration
- [x] USGS Earthquake API integration (past 3 days, M2.5+).
- [x] NASA EONET v3 API integration (open events, limit 50).
- [x] Nearest disaster calculation using Haversine formula with Philippine boundary filtering for admins.
- [x] Philippine active fault lines overlay (GeoJSON).
- [x] Philippine volcanoes overlay (GeoJSON).
- [x] KMZ file serving with correct MIME type.

### Phase 3: Dashboard & Visualization
- [x] Admin Command Center: Three-panel layout with employee layers, Leaflet.js map, and hazard sidebar.
- [x] Employee Disaster Tracker Dashboard: Three-panel layout with own location and hazard monitoring.
- [x] Workforce Geography analytics page with office/type distribution and interactive map.
- [x] Employee markers color-coded by DTI category.
- [x] Separate Home/Office/Latest icons on admin Personnel Directory.
- [x] Standard and Satellite map tile layers.
- [x] Responsive layout (stacks vertically on ≤1200px screens).

### Phase 4: Security & Performance
- [x] SecurityHeaders middleware (CSP, X-Frame-Options, HSTS, cache control).
- [x] AdminMiddleware for role-based access control.
- [x] API rate limiting (30 req/min on location endpoint).
- [x] Dashboard stats caching (5 minutes).
- [x] Admin ID and dropdown option caching (10 minutes).
- [x] Last activity update throttling (60-second debounce).
- [x] Database indexes on `employee_locations` (recorded_at, office, type, user_id+recorded_at) and `users` (last_activity_at).

---

## 3. Known Limitations & Future Considerations
- [ ] No forced password change on first login for new accounts (default password: `password123`).
- [ ] No rate limiting on admin CRUD or disaster API proxy endpoints.
- [ ] No push notifications or automated alerts based on disaster proximity.
- [ ] No geofencing or virtual perimeter-based check-ins.
- [ ] No native mobile app — browser-only.
- [ ] No automated/scheduled disaster data syncing — currently on-demand via button click.
- [ ] Disaster data not persisted in the database — fetched fresh each time.

---

## 4. Security Status
| Control | Status |
| :--- | :--- |
| SQL Injection Mitigation | ✅ Verified (Eloquent parameter binding) |
| CSRF Protection | ✅ Verified (Laravel CSRF middleware) |
| XSS Protection | ✅ Verified (Blade escaping + CSP header) |
| Access Control | ✅ Verified (AdminMiddleware + auth middleware) |
| API Throttling | ✅ Implemented (30 req/min on `/api/location`) |
| PII Protection | ✅ RBAC-enforced data isolation |
| Default Passwords | ⚠️ Known risk — no forced change |
