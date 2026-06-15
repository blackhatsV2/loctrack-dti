[← Back to README](README.md) | [← Previous: Process Workflow](2_Process_Workflow.md) | [Next: System Architecture →](4_System_Architecture.md)

# Functional Requirements: Preparedness, Safety & Continuity Portal: Workforce Locator

## 1. Authentication & Authorization
- **Login**: Users authenticate via email or full name (Firstname Lastname format) and password.
- **Role-Based Access Control (RBAC)**:
    - **Employees**: Can submit location data, view their own history, reuse past locations, update their profile/address/password, and view live disaster data on their dashboard map.
    - **Admins**: Full access to the Command Center dashboard, employee directory management (add/edit/delete), location history auditing (view/delete individual/delete bulk/clear all), workforce geography analytics, and their own profile management.
- **Role-Based Redirect**: Admins are redirected to `/admin/dashboard` on login; employees to `/dashboard`.

## 2. Location Tracking
- **GPS Capture**: Browser-based Geolocation API coordinates submitted via POST to `/api/location`.
- **Tracking Data Per Entry**:
    - `user_id`: Reference to the reporting employee.
    - `latitude` / `longitude`: Decimal precision GPS data (10,8 and 11,8).
    - `recorded_at`: Server-side timestamp.
    - `type`: Location category (`home`, `office`, `broadcast`, or null).
- **Carried-Forward Metadata**: Each new entry inherits `address`, `office`, `employee_id_no`, `mobile_no`, and `employee_type` from the user's most recent record (or from the user profile if no prior record exists).
- **Rate Limiting**: The `/api/location` endpoint is throttled to 30 requests per minute per user.
- **Location Broadcast**: Separate endpoint (`/api/broadcast`) for automatic location capture with `type` set to `broadcast`.
- **Location Reuse**: Employees can replicate a past location entry as a new record with the current timestamp via POST to `/api/location/reuse/{id}`.

## 3. Address & Profile Management
- **Home/Office Address**: Employees can set their home address or office location with coordinates via POST to `/api/address`. Each update creates a new location record with the appropriate `type`.
- **Profile Update**: Employees update name, email, employee ID, mobile, office, and employee type via POST to `/profile/update`. Changes are synced to the latest location record.
- **Password Change**: Employees can change their password via POST to `/profile/password` (requires current password, new must differ, minimum 8 characters).
- **Admin Profile**: Admins update name, email, and password via PUT to `/admin/profile`.

## 4. Admin Command Center
- **Statistics**: Dashboard displays total personnel count (non-admin users). Card links to the employee directory.
- **Interactive Map**: Three-panel layout with Leaflet.js:
    - **Left Panel**: Employee layers with real-time search, category checkboxes, Personnel Directory with clickable Home/Office/Latest cards, and Show All / Hide All controls.
    - **Center Panel**: Map with Standard and Satellite tile layers, employee markers (color-coded by category), earthquake circle markers (sized by magnitude), and NASA event markers.
    - **Right Panel**: Hazard list with All/USGS/NASA filter pills, and toggleable static overlays (Active Faults PH, Volcanoes PH).
- **Online Personnel**: Section showing employees with `last_activity_at` within the past 24 hours. Auto-refreshes every 30 seconds via AJAX polling to `/admin/online-users`.
- **Sync Hazards**: On-demand re-fetching of USGS earthquake data and NASA EONET events.

## 5. Employee Disaster Tracker Dashboard
- **Dashboard Cards**: "Total Location Logs" card (clickable, links to history page) and a profile mini-card with a link to the Geography page.
- **Three-Panel Map**: Same structure as admin but employees only see their own markers. Search is available to admins only on this view.
- **Hazard Data**: Same USGS/NASA integration and static layer toggles as the admin view.

## 6. Employee Directory (Admin)
- **List View**: Table of all non-admin employees with Name/Email, ID No., Office, Mobile, and action links (Edit, History, Delete).
- **Client-Side Search**: Instant filtering by name, email, ID number, or mobile number. Office dropdown filter. Clear button resets all filters.
- **Add Employee Modal**: Form with fields for Name (required), Email (required), ID No., Employee Type (searchable dropdown with "Others" custom input), Address, Mobile, Office (searchable dropdown with "Others" custom input), Latitude, Longitude. Default coordinates assigned from known DTI office locations if not provided. Loading overlay shown during form submission.
- **Edit Employee**: Full-page form at `/admin/employees/{user}/edit` for updating all employee and location fields.
- **Delete Employee**: Confirmation modal. Deletion cascades to all associated location records.

## 7. Location History & Auditing
- **Employee History**: Paginated view at `/history` showing the employee's own location logs ordered by most recent.
- **Admin History View**: Paginated view at `/admin/employees/{user}/history` showing any employee's location logs.
- **Delete Individual Log**: Admin can delete a single location record via DELETE to `/admin/history/{employeeLocation}`.
- **Bulk/Batch Delete**: Admin can delete selected logs or clear all history for a user via DELETE to `/admin/employees/{user}/history/bulk` with `action` set to `selected` (with `ids` array) or `all`.

## 8. Workforce Geography & Analytics (Admin)
- **Route**: `/admin/workforce`.
- **Data**: Latest location per employee (excluding admins), grouped by office and employee type.
- **Visualization**: Interactive map with all latest employee positions, office distribution data, employee type distribution data, and synchronized data list with filtering.

## 9. Nearest Disaster API
- **Endpoint**: GET `/api/notifications/nearest-disaster`.
- **Logic**: Fetches the user's latest location, queries USGS and NASA APIs, calculates distance to each event using the Haversine formula, and returns the nearest disaster.
- **Admin Enhancement**: For admin users, also returns a list of disasters within Philippine geographic boundaries (lat 4.5-21.5, lon 116.0-127.0).

## 10. External API Integrations
- **USGS Earthquake API**: Fetches global earthquakes from the past 3 days with magnitude ≥ 2.5, ordered by time. Endpoint: `https://earthquake.usgs.gov/fdsnws/event/1/query`.
- **NASA EONET v3 API**: Fetches up to 50 currently open natural events. Endpoint: `https://eonet.gsfc.nasa.gov/api/v3/events`.
- Both APIs are called on demand with a 30-second timeout. Errors are logged and a 503 response is returned to the client.

## 11. Static Geospatial Data
- **Philippine Active Faults**: GeoJSON file at `/public/maps/ph_faults.json`. Rendered as dashed red lines on the map.
- **Philippine Volcanoes**: GeoJSON file at `/public/maps/ph_volcanoes.json`. Rendered as yellow circle markers.
- **KMZ Files**: `active_faults.kmz`, `active_volcano.kmz`, and `aft_2021_000000000_02.kmz` served from `/public/maps/` with correct MIME type.

## 12. Performance & Caching
- **Dashboard Stats**: Cached for 5 minutes (`admin_dashboard_stats`).
- **Admin IDs**: Cached for 10 minutes (`admin_user_ids`).
- **Dropdown Options**: Office and employee type lists cached for 10 minutes.
- **Last Activity Throttle**: `UpdateLastActivity` middleware updates `last_activity_at` at most once per 60 seconds per session to reduce database writes.

## 13. Security
- **SecurityHeaders Middleware**: Sets `X-Content-Type-Options`, `X-Frame-Options`, `X-XSS-Protection`, `Referrer-Policy`, `Content-Security-Policy`, and `Strict-Transport-Security` (production only). Disables caching for HTML/API responses while allowing static asset caching.
- **AdminMiddleware**: Ensures only users with `is_admin = true` can access `/admin/*` routes.
- **CSRF Protection**: Laravel's built-in CSRF token verification on all POST/PUT/DELETE requests.
- **Password Hashing**: Bcrypt via Laravel's `hashed` cast.
- **Input Validation**: All controller methods validate input with Laravel's validation rules.
