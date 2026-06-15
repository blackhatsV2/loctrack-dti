[← Back to README](README.md) | [← Previous: Project Plan](10_Project_Plan.md)

# Project Modules: Preparedness, Safety & Continuity Portal: Workforce Locator

## 1. Authentication Module
**Controller**: `AuthController`
**Routes**: `GET /login`, `POST /login`, `POST /logout`

- **Email or Name Login**: Users can authenticate using their email address or full name (in "Firstname Lastname" format). Name-based login searches by exact match, LIKE match, and reversed "Lastname, Firstname" format.
- **Role-Based Redirect**: Admins redirected to `/admin/dashboard`, employees to `/dashboard`.
- **Session Management**: Standard Laravel session handling with `invalidate()` and `regenerateToken()` on logout.

## 2. Employee Dashboard Module
**Controller**: `DisasterController@index`
**Route**: `GET /dashboard`
**View**: `disasters.blade.php`

- **Dashboard Cards**: "Total Location Logs" count (clickable — links to `/history`) and a profile mini-card with name, email, employee type, and a link to the Geography page.
- **Three-Panel Map Layout**: Left sidebar shows the employee's own marker layer with visibility toggle. Center panel is a Leaflet.js map (CartoDB Light / Satellite tiles). Right sidebar shows live hazard events with All/USGS/NASA filter pills and toggleable static overlays (Active Faults, Volcanoes).
- **Data Sync**: "Sync Data" button re-fetches hazard data and reloads employee markers.

## 3. Location Tracking Module
**Controller**: `LocationController`
**Routes**: `POST /api/location`, `POST /api/broadcast`, `POST /api/location/reuse/{id}`, `POST /api/address`

- **GPS Submission** (`store`): Validates latitude and longitude, creates a new `EmployeeLocation` record with the current timestamp. Metadata (`address`, `office`, `employee_id_no`, `mobile_no`, `employee_type`) carried forward from the user's most recent record. Rate limited to 30 requests/minute.
- **Broadcast** (`broadcast`): Same as store but sets `type` to `broadcast`.
- **Reuse** (`reuse`): Replicates an existing location record with a new timestamp. Employees can only reuse their own records; admins can reuse any.
- **Address Update** (`updateAddress`): Creates a new location record with `type` of `home` or `office`, updating the corresponding address or office field while carrying forward other metadata.

## 4. Profile Management Module
**Controller**: `LocationController` (employees), `AdminController` (admins)
**Routes**: `POST /profile/update`, `POST /profile/password`, `PUT /admin/profile`

- **Employee Profile Update**: Updates name, email, employee ID, mobile, office, and employee type on the `users` table. Also syncs these fields to the latest `employee_locations` record.
- **Password Change**: Requires current password. New password must be at least 8 characters and different from current.
- **Admin Profile Update**: Updates name, email, and optional password.

## 5. Employee Location History Module
**Controllers**: `LocationController@history` (employees), `AdminController@locationHistory` (admins)
**Routes**: `GET /history`, `GET /admin/employees/{user}/history`
**Views**: `history.blade.php`, `admin/employee-history.blade.php`

- **Employee View**: Paginated list (25 per page) of the authenticated user's own location records, ordered by most recent.
- **Admin View**: Paginated list (25 per page) of any employee's location records.
- **Delete Individual** (`AdminController@destroyLocation`): `DELETE /admin/history/{employeeLocation}`. Supports JSON responses.
- **Bulk Delete** (`AdminController@destroyLocationsBulk`): `DELETE /admin/employees/{user}/history/bulk` with `action=selected` (with `ids` array) or `action=all` to clear all history.

## 6. Admin Command Center Module
**Controller**: `AdminController@dashboard`
**Route**: `GET /admin/dashboard`
**View**: `admin/dashboard.blade.php`

- **Statistics**: Total Personnel card (links to `/admin/employees`).
- **Unified Map**: Three-panel layout — left sidebar (employee search, category checkboxes, Personnel Directory with Home/Office/Latest cards, Show All/Hide All buttons), center map (Leaflet.js with employee and hazard markers), right sidebar (hazard list with filter pills, static layer toggles).
- **Employee Categories**: NC Negros Occidental, NC Iloilo, NC Guimaras, NC Capiz, NC Antique, NC Aklan, DTI6 Regular Employees. Derived from `employee_type` field.
- **Online Personnel**: Section below the map showing users with `last_activity_at` within 24 hours. Auto-refreshes every 30 seconds via `GET /admin/online-users`.
- **Hazard Sync**: Button triggers `GET /api/disasters/earthquakes` and `GET /api/disasters/events`.

## 7. Employee Directory Module (Admin)
**Controller**: `AdminController` (index, store, edit, update, destroy)
**Routes**: `GET /admin/employees`, `POST /admin/employees`, `GET /admin/employees/{user}/edit`, `PUT /admin/employees/{user}`, `DELETE /admin/employees/{user}`
**Views**: `admin/employees.blade.php`, `admin/employee-edit.blade.php`

- **List**: Table of all non-admin employees with client-side search (name, email, ID, mobile) and office dropdown filter. Instant filtering with visible count.
- **Add (Modal)**: Modal form with fields for Name, Email, ID No., Employee Type (searchable select with "Others"), Address, Mobile, Office (searchable select with "Others"), Latitude, Longitude. Coordinates default to known DTI office positions if not provided. Loading overlay during submission. Default password: `password123`.
- **Edit (Page)**: Full-page form for updating user and location fields. Auto-assigns office coordinates if lat/lng are both 0.
- **Delete (Modal)**: Confirmation dialog. Cascades to all location records.
- **Cache Invalidation**: Dashboard stats cache cleared on add, edit, and delete operations.

## 8. Disaster & Hazard Module
**Controller**: `DisasterController`
**Routes**: `GET /api/disasters/earthquakes`, `GET /api/disasters/events`, `GET /api/notifications/nearest-disaster`

- **USGS Earthquakes** (`getEarthquakes`): Proxies `earthquake.usgs.gov` API. Parameters: past 3 days, M2.5+, ordered by time. 30-second timeout.
- **NASA EONET** (`getNaturalEvents`): Proxies `eonet.gsfc.nasa.gov` API v3. Parameters: open status, limit 50. 30-second timeout.
- **Nearest Disaster** (`nearestDisaster`): Calculates Haversine distance from the user's latest location to all fetched USGS and NASA events. Returns the nearest event. For admins, also returns disasters within Philippine boundaries (lat 4.5–21.5, lon 116.0–127.0) sorted by time descending.
- **Error Handling**: API failures are caught, logged via `Log::error()`, and return a 503 JSON response.

## 9. Workforce Geography Module (Admin)
**Controller**: `AdminController@workforce`
**Route**: `GET /admin/workforce`
**View**: `admin/workforce.blade.php`

- **Data**: Fetches the latest location per employee (excluding admins) using a `MAX(id)` subquery grouped by `user_id`.
- **Analytics**: Office distribution and employee type distribution counts, computed from the latest location data.
- **Visualization**: Interactive Leaflet.js map with all latest employee positions. Filtering by office and employee type.

## 10. Static Geospatial Data Module
**Route**: `GET /api/maps/{filename}` (for KMZ files)
**Static Files**: `public/maps/`

- **GeoJSON**: `ph_faults.json` (active fault lines, rendered as red dashed lines) and `ph_volcanoes.json` (volcano locations, rendered as yellow circle markers). Loaded via JavaScript `fetch()` calls.
- **KMZ Files**: `active_faults.kmz`, `active_volcano.kmz`, `aft_2021_000000000_02.kmz`. Served with `Content-Type: application/vnd.google-earth.kmz` and CORS headers.

## 11. Security & Performance Module
**Middleware**: `SecurityHeaders`, `AdminMiddleware`, `UpdateLastActivity`, `throttle`

- **SecurityHeaders**: Applied globally. Sets CSP, X-Frame-Options, X-XSS-Protection, Referrer-Policy, HSTS (production), and smart cache control (no-cache for HTML/API, default for static assets).
- **AdminMiddleware**: Applied to all `/admin/*` routes. Checks `is_admin` flag.
- **UpdateLastActivity**: Updates `users.last_activity_at` once per 60 seconds per session to minimize database writes.
- **Rate Limiting**: `throttle:30,1` on `/api/location`.
- **Caching**: Dashboard stats (5 min), admin IDs (10 min), dropdown options (10 min).
- **Database Indexes**: `recorded_at`, `office`, `type`, `user_id+recorded_at` on `employee_locations`; `last_activity_at` on `users`.
