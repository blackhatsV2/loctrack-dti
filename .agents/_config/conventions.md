# Coding Conventions

This document defines the coding standards, architectural patterns, and conventions for the **Preparedness, Safety & Continuity Portal (PSCP): Workforce Locator** project (Laravel 12 + Leaflet.js). All stages must adhere strictly to these conventions.

---

## PHP & Laravel Conventions

### General
- **PHP Version**: 8.2+
- **Framework**: Laravel 12
- **Standard**: PSR-12 (Extended Coding Style)
- **Strict Types**: Add `declare(strict_types=1);` to all newly created PHP files.

### Naming Standards
| Element | Convention | Example |
|---|---|---|
| Controllers | PascalCase + Controller suffix | `EmployeeLocationController` |
| Models | PascalCase (singular) | `EmployeeLocation`, `User` |
| Services | PascalCase + Service suffix | `DisasterDataService`, `HaversineService` |
| Methods | camelCase | `getOnlinePersonnel()`, `getNearestDisaster()` |
| Variables | camelCase | `$activeHazardList`, `$employeeLocations` |
| Constants | UPPER_SNAKE_CASE | `EARTH_RADIUS_KM`, `CACHE_DISASTER_TTL` |
| Database Tables | snake_case (plural) | `users`, `employee_locations` |
| Database Columns | snake_case | `employee_id`, `latitude`, `longitude` |
| Named Routes | dot.notation | `admin.dashboard`, `employee.location.store` |
| Config Keys | snake_case | `services.usgs.endpoint`, `services.nasa.eonet_url` |

### File & Directory Structure
```
app/
├── Http/
│   ├── Controllers/       ← Thin controllers (~50 lines max per method)
│   │   ├── Admin/         ← Admin command center & audit controllers
│   │   └── Employee/      ← Employee disaster tracker & locator controllers
│   ├── Middleware/        ← Auth, Admin, and Rate-limiting middleware
│   └── Requests/          ← Form Request validation classes
├── Models/                ← Eloquent models (User, EmployeeLocation)
├── Services/              ← Business logic (DisasterApiService, HaversineCalculator)
└── Providers/             ← Service providers
```

### Controller Rules
- Controllers must remain **thin**. Delegate complex filtering, spatial processing, and third-party API fetching to `app/Services/`.
- Use Laravel Form Request classes (`app/Http/Requests/`) for input validation.
- Always return explicit typed responses: `JsonResponse`, `View`, or `RedirectResponse`.

### Model & Eloquent Rules
- Explicitly define `$fillable` or `$guarded` on all Eloquent models.
- Declare return type hints on all relationship methods (e.g., `hasMany()`, `belongsTo()`).
- Eager load relationships (`with(['user', 'latestLocation'])`) to prevent N+1 query bottlenecks.
- Use query scopes for reusable filters (e.g., `scopeActiveWithinHours($query, int $hours)`).

---

## Leaflet.js & Frontend Conventions

### Blade Views & Layouts
- Layouts are situated in `resources/views/layouts/` (e.g., `app.blade.php`, `admin.blade.php`).
- Reusable UI elements belong in `resources/views/components/` (e.g., `map-legend.blade.php`, `hazard-card.blade.php`).
- Admin panels: `resources/views/admin/`
- Employee views: `resources/views/employee/`

### Leaflet.js & Geospatial Handling
- Map scripts must be modularized inside `resources/js/` (e.g., `resources/js/map/leaflet-manager.js`, `resources/js/map/disaster-layers.js`).
- Use custom marker icons and distinct color palettes for employee categories:
  - PO offices & provincial staff vs. NC (Negros Occidental, Iloilo, Guimaras, Capiz, Antique, Aklan) vs. DTI6 Regular Employees.
- Clean up map markers and layers on live polling updates to prevent memory leaks in long-running dashboards.
- Handle GeoJSON fault line and volcano overlays asynchronously with error fallbacks.

### Styling & Asset Bundling
- Styling is built with **Tailwind CSS v4**. Avoid inline styles except for dynamic Leaflet map heights or z-index overrides.
- Use **Vite 7** for asset compilation: `@vite(['resources/css/app.css', 'resources/js/app.js'])`.

---

## Database & Indexing Conventions

### Migrations
- Descriptive migration names: `create_employee_locations_table`, `add_indexes_to_employee_locations_table`.
- Coordinates must use `decimal(10, 7)` or spatial types if configured.
- Ensure composite indexes exist for frequent query filters: `(user_id, created_at)`, `(latitude, longitude)`.
- Use foreign key constraints: `$table->foreignId('user_id')->constrained()->cascadeOnDelete();`.

### Seeding & Data Testing
- Use Model Factories for fake location generator testing (`EmployeeLocationFactory`).
- Production/Development seeders must provide representative test coordinates around DTI Region 6 offices (Iloilo, Bacolod, Roxas, Kalibo, San Jose, Jordan).

---

## Git Commit & Workflow Conventions

### Commit Format
Format: `type(scope): description`

- **Types**: `feat`, `fix`, `docs`, `style`, `refactor`, `test`, `chore`, `security`
- **Examples**:
  - `feat(map): add NASA EONET v3 hazard overlay filtering`
  - `fix(haversine): resolve division by zero when calculating identical points`
  - `security(vapt): sanitize input parameters on location history export`
  - `test(locator): add unit tests for 24h active personnel polling`
