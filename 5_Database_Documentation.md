# Database Documentation

This document provides a detailed description of the physical database schema for the Employee Location Tracking System.

## Schema Overview
The system uses a relational schema designed to store user information and their associated periodic location updates.

---

## 1. `users` Table
Stores basic profile and authentication data for all users.

| Column | Type | Nullable | Description |
| :--- | :--- | :--- | :--- |
| `id` | bigint | No | Primary Key |
| `name` | string | No | Full name of the user |
| `email` | string | No | Primary login identifier (Unique) |
| `email_verified_at` | timestamp | Yes | Verification check |
| `password` | string | No | Hashed password |
| `is_admin` | boolean | No | Role identifier (True = Admin, False = Employee) |
| `remember_token` | string | Yes | Persistence session token |
| `created_at` | timestamp | Yes | Record creation time |
| `updated_at` | timestamp | Yes | Record update time |

---

## 2. `employee_locations` Table
The core table storing tracking data.

| Column | Type | Nullable | Description |
| :--- | :--- | :--- | :--- |
| `id` | bigint | No | Primary Key |
| `user_id` | foreignId | No | Link to `users.id` (onDelete: cascade) |
| `employee_id_no` | string | Yes | Unique corporate employee identifier |
| `address` | string | Yes | Last known physical address |
| `latitude` | decimal (10,8) | No | GPS Latitude |
| `longitude` | decimal (11,8) | No | GPS Longitude |
| `mobile_no` | string | Yes | Contact number |
| `office` | string | Yes | Assigned branch or office location |
| `employee_type` | string | Yes | Status (e.g., Permanent, Probation) |
| `recorded_at` | timestamp | No | Exact time location was reported |
| `created_at` | timestamp | Yes | Database entry time |
| `updated_at` | timestamp | Yes | Record modification time |

---

## 3. Supplementary Tables
*   **`cache`**: Standard Laravel cache storage for performance optimization.
*   **`jobs`**: Table for queuing background tasks (if implemented).
*   **`migrations`**: Internal Laravel table for tracking schema versions.

## Indexes
- **`employee_locations_user_id_foreign`**: Speeds up lookups for a specific user's history.
- **`employee_locations_recorded_at_index`**: (Created via migration `add_indexes_to_employee_locations_table`) Optimizes time-series queries for dashboards and reports.
