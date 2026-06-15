[← Back to README](README.md) | [← Previous: VAPT Report](8_VAPT_Report.md) | [Next: Project Plan →](10_Project_Plan.md)

# Project Presentation: Preparedness, Safety & Continuity Portal: Workforce Locator

## Slide 1: Welcome
**Preparedness, Safety & Continuity Portal: Workforce Locator**
*Real-time employee location monitoring with integrated disaster awareness for DTI Region 6.*

---

## Slide 2: The Problem
- DTI Region 6 manages personnel across 7 provincial offices (Aklan, Antique, Capiz, Guimaras, Iloilo, Negros Occidental, and the Regional Office).
- No centralized way to see where employees are relative to active seismic and natural hazards.
- Manual location reporting and fragmented tracking systems.
- No historical audit trail of employee positions for compliance or safety review.

---

## Slide 3: The Solution
- **Unified Command Center**: A single three-panel dashboard showing all employee locations plotted on a Leaflet.js map alongside live USGS earthquake data and NASA natural event data.
- **Static Hazard Overlays**: Philippine active fault lines and volcano locations rendered from local GeoJSON files.
- **Employee Self-Service**: Employees report their GPS position via browser Geolocation API and manage their own profile and addresses.
- **Built on Laravel 12**: PHP 8.2+, Tailwind CSS v4, MySQL, Vite 7.

---

## Slide 4: Employee Features
- **Disaster Tracker Dashboard**: Three-panel map view with hazard monitoring, profile card, and total location logs.
- **One-Click Location Reporting**: Submit GPS coordinates via the browser with automatic metadata carry-forward.
- **Location History**: View past entries, reuse a past location with a new timestamp.
- **Profile & Address Management**: Update home address, office location, personal details, and password.

---

## Slide 5: Admin Features
- **Command Center Map**: Employee markers color-coded by category, real-time search and filtering, Personnel Directory with clickable Home/Office location cards.
- **Live Hazard Integration**: USGS earthquakes (M2.5+, past 3 days), NASA EONET events, filterable by source (All/USGS/NASA).
- **Online Personnel Monitoring**: Live list of employees active in the last 24 hours, auto-refreshing every 30 seconds.
- **Employee Directory**: Full CRUD — add via modal, edit on dedicated page, delete with confirmation. Instant client-side search by name/email/ID/mobile.
- **Location History Auditing**: Per-employee paginated history. Delete individual logs, bulk delete selected, or clear all.
- **Workforce Geography**: Office and employee type distribution analytics with interactive map.

---

## Slide 6: Security
- **VAPT Verified**: Mitigated SQL injection, CSRF, XSS, and broken access control.
- **SecurityHeaders Middleware**: CSP, X-Frame-Options, HSTS (production), cache control.
- **AdminMiddleware**: Role-based access control on all admin routes.
- **API Rate Limiting**: 30 requests/minute on the location submission endpoint.
- **Input Validation**: All endpoints validate input types, sizes, and constraints.

---

## Slide 7: Technical Highlights
- **Caching Strategy**: Dashboard stats (5 min), admin IDs (10 min), dropdown options (10 min). Last activity updates throttled to once per 60 seconds.
- **Map Features**: Standard and Satellite tile layers, GeoJSON fault/volcano overlays, KMZ file support, Haversine-based nearest disaster calculation.
- **Database Indexing**: Composite and single-column indexes on `employee_locations` for time-series, office, type, and user lookups.
- **Responsive Design**: Three-panel layout stacks vertically on mobile (≤1200px). Employee Layers on top, map in middle, Global Hazards below.

---

## Slide 8: Closing
**Thank you.**
*Safety through visibility. Efficiency through integration.*
