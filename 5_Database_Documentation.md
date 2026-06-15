[← Back to README](README.md) | [← Previous: System Architecture](4_System_Architecture.md) | [Next: Deployment Guide →](6_Deployment_Guide.md)

# Database Documentation: Preparedness, Safety & Continuity Portal: Workforce Locator

## Schema Overview
The system uses a MySQL relational schema with two primary tables for user data and location tracking, plus standard Laravel infrastructure tables.

---

## 1. `users` Table
Stores credentials, profile data, and role information for all staff and administrators.

| Column | Type | Nullable | Description |
| :--- | :--- | :--- | :--- |
| `id` | bigint (auto-increment) | No | Primary Key |
| `name` | string | No | User's full name |
| `email` | string (unique) | No | Login identifier. Also supports name-based login lookup. |
| `password` | string | No | Bcrypt-hashed credential (`hashed` cast) |
| `is_admin` | boolean (default: false) | No | Role flag. `true` = Admin, `false` = Employee |
| `employee_id_no` | string(50) | Yes | Corporate employee identifier |
| `mobile_no` | string(20) | Yes | Primary contact number |
| `office` | string(100) | Yes | Assigned office or department |
| `employee_type` | string(50) | Yes | Employment classification (e.g., NC Negros Occidental, DTI6 Regular) |
| `last_activity_at` | timestamp | Yes | Last time the user made a request (updated at most every 60 seconds) |
| `email_verified_at` | timestamp | Yes | Email verification timestamp (standard Laravel, not actively used) |
| `remember_token` | string | Yes | Persistent session token |
| `created_at` | timestamp | Yes | Record creation time |
| `updated_at` | timestamp | Yes | Last record update time |

---

## 2. `employee_locations` Table
Core repository for geographical tracking data. Each row represents a single location submission.

| Column | Type | Nullable | Description |
| :--- | :--- | :--- | :--- |
| `id` | bigint (auto-increment) | No | Primary Key |
| `user_id` | foreignId | No | Reference to `users.id` (onDelete: cascade) |
| `type` | string | Yes | Location category: `home`, `office`, `broadcast`, or null |
| `latitude` | decimal(10,8) | No | GPS Latitude |
| `longitude` | decimal(11,8) | No | GPS Longitude |
| `recorded_at` | timestamp | No | Time of location capture |
| `address` | string | Yes | Human-readable address (home address) |
| `employee_id_no` | string | Yes | Snapshot of employee ID at recording time |
| `mobile_no` | string | Yes | Snapshot of mobile number at recording time |
| `office` | string | Yes | Snapshot of office at recording time |
| `employee_type` | string | Yes | Snapshot of employee type at recording time |
| `created_at` | timestamp | Yes | Record creation time |
| `updated_at` | timestamp | Yes | Last record update time |

---

## 3. Infrastructure Tables
- **`cache`**: Laravel cache storage. Used for dashboard stats (5 min), admin IDs (10 min), and dropdown options (10 min).
- **`cache_locks`**: Lock management for cache operations.
- **`jobs`**: Queue table for background tasks.
- **`job_batches`**: Batch job tracking.
- **`failed_jobs`**: Failed job storage.
- **`sessions`**: Session storage (if using database driver).
- **`migrations`**: Schema version tracking.

## Performance Indexes
| Index Name | Table | Column(s) | Purpose |
| :--- | :--- | :--- | :--- |
| `employee_locations_recorded_at_index` | employee_locations | `recorded_at` | Speeds up time-based queries and activity feeds |
| `employee_locations_office_index` | employee_locations | `office` | Optimizes office-based filtering |
| `employee_locations_type_index` | employee_locations | `type` | Optimizes Home/Office distribution queries |
| `employee_locations_user_id_recorded_at_index` | employee_locations | `user_id`, `recorded_at` | Composite index for per-user history lookups |
| `users_last_activity_at_index` | users | `last_activity_at` | Efficiently identifies active/online users |

## Relationships
- `User` → `hasMany` → `EmployeeLocation` (via `user_id`)
- `EmployeeLocation` → `belongsTo` → `User` (via `user_id`)
- Cascade delete: Deleting a `User` automatically deletes all their `EmployeeLocation` records.
