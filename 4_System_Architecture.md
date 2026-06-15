[← Back to README](README.md) | [← Previous: Functional Requirements](3_Functional_Requirements.md) | [Next: Database Documentation →](5_Database_Documentation.md)

# System Architecture: Preparedness, Safety & Continuity Portal: Workforce Locator

## Architecture Pattern
The application follows the **Model-View-Controller (MVC)** pattern provided by Laravel.

- **Model**: Eloquent ORM with two models — `User` and `EmployeeLocation`. `User` has a `hasMany` relationship to `EmployeeLocation`.
- **View**: Blade templates extending a shared `layouts/app.blade.php` layout. Styled with Tailwind CSS v4 and enhanced with inline JavaScript (no frontend framework).
- **Controller**: Three main controllers handle application logic:
    - `AuthController` — Login (email or name-based), logout.
    - `AdminController` — Admin dashboard, employee CRUD, location history management, workforce analytics, admin profile.
    - `LocationController` — GPS submission, address/profile updates, password changes, location reuse, broadcast, geography page, employee history.
    - `DisasterController` — Employee dashboard, USGS earthquake data, NASA EONET data, nearest disaster calculation.

## Technology Stack

### Core
| Component | Technology |
| :--- | :--- |
| Backend | Laravel 12 (PHP 8.2+) |
| Frontend | Blade Templates, Tailwind CSS v4, inline JavaScript |
| Database | MySQL |
| Asset Bundling | Vite 7 |

### Client-Side Libraries
| Library | Purpose |
| :--- | :--- |
| Leaflet.js 1.9.4 | Interactive maps for employee and hazard visualization |
| Leaflet.MarkerCluster 1.5.3 | Marker clustering for dense map data |
| Chart.js 4.x | Distribution charts on the workforce analytics page |
| Axios 1.x | HTTP client (available but most AJAX uses native `fetch`) |

### External APIs
| API | Purpose |
| :--- | :--- |
| USGS Earthquake API | Live seismic event data (past 3 days, M2.5+) |
| NASA EONET v3 API | Active natural events (wildfires, storms, etc.) |
| HTML5 Geolocation API | Browser-based GPS coordinate capture |

### Static Map Assets
| File | Content |
| :--- | :--- |
| `ph_faults.json` | Philippine active fault lines (GeoJSON) |
| `ph_volcanoes.json` | Philippine volcano locations (GeoJSON) |
| `active_faults.kmz` | KMZ fault data |
| `active_volcano.kmz` | KMZ volcano data |
| `aft_2021_000000000_02.kmz` | Additional KMZ hazard data |

## Middleware Stack
- **`auth`**: Laravel's built-in authentication guard. Applied to all employee and admin routes.
- **`AdminMiddleware`**: Checks `is_admin` flag on the user. Applied to all `/admin/*` routes.
- **`SecurityHeaders`**: Applies security HTTP headers (CSP, X-Frame-Options, HSTS, etc.) and disables caching for HTML/API responses.
- **`UpdateLastActivity`**: Updates `users.last_activity_at` at most once per 60 seconds per session.
- **`throttle:30,1`**: Laravel's rate limiter on the `/api/location` endpoint.

## Key System Components

### 1. Employee Dashboard (DisasterController@index)
Serves the `/dashboard` route. Displays total check-ins, a profile card, and a three-panel map layout with personnel layers, Leaflet map, and hazard monitoring sidebar.

### 2. Admin Command Center (AdminController@dashboard)
Serves `/admin/dashboard`. Shows a total personnel stat card, a three-panel unified map with employee search, category filtering, personnel directory, hazard list, and static layer toggles. Includes an online personnel section with 30-second auto-refresh.

### 3. Employee Directory (AdminController@index, store, edit, update, destroy)
Full CRUD for employee management at `/admin/employees`. Add via modal, edit on a dedicated page, delete with confirmation. Coordinates default to known DTI Region 6 office positions when not provided.

### 4. Location History (AdminController@locationHistory, destroyLocation, destroyLocationsBulk)
Per-employee paginated history at `/admin/employees/{user}/history`. Supports individual delete, selected bulk delete, and clear-all operations.

### 5. Workforce Geography (AdminController@workforce)
Analytics page at `/admin/workforce` showing latest employee locations, office distribution, and employee type distribution.

### 6. Disaster Data Layer (DisasterController)
Fetches and serves USGS earthquake and NASA EONET data via API endpoints. Includes nearest-disaster calculation with Haversine distance formula.

### 7. Telemetry API (LocationController@store, broadcast)
RESTful endpoints for GPS coordinate submission. Rate-limited. Carries forward metadata from the employee's most recent location record.

## Data Flow
```
Employee Browser → Geolocation API → POST /api/location → LocationController@store → MySQL (employee_locations)
                                                                                          ↓
Admin Dashboard ← Leaflet.js Map ← GET /api/locations ← LocationController@index ← MySQL
                                  ← GET /api/disasters/earthquakes ← DisasterController ← USGS API
                                  ← GET /api/disasters/events ← DisasterController ← NASA API
                                  ← /maps/*.json (static GeoJSON files)
```
