[← Back to README](README.md) | [← Previous: Process Workflow](2_Process_Workflow.md) | [Next: System Architecture →](4_System_Architecture.md)

# Functional Requirements: Employee Location Tracking

This document specifies the core functionalities for the Employee Location Tracking System.

## 1. Authentication & Authorization
- **Secure Login**: Users must authenticate via email and password.
- **Role-Based Access Control (RBAC)**:
    - **Employees**: Can submit location data and view their own limited dashboard.
    - **Admins**: Full access to the command center, live map, and all employee track logs.
- **Admin Management**: Capability for admins to manage user roles and profiles.

## 2. Real-time Location Tracking
- **GPS Capture**: The system handles browser-based Geolocation API coordinates.
- **Core Tracking Data**: Every entry must include:
    - `user_id`: Reference to the reporting staff.
    - `latitude` / `longitude`: High-precision GPS data.
    - `recorded_at`: The server-side or device-captured timestamp.
- **Supplemental Meta**:
    - `address`: Automatically reverse-geocoded physical location.
    - `employee_id_no`, `mobile_no`, `office`, `employee_type`.

## 3. Administrative Terminal
- **Live Monitoring Map**: An interactive map plotting the most recent reported locations.
- **Employee Directory**: Searchable and editable database of all registered staff.
- **History Audit Logs**: Access to comprehensive, time-stamped location history for each user.
- **Data Filtering**: Ability to filter records by employee, date range, or department.

## 4. System Integrity & Security
- **API Throttling**: Rate limiting (e.g., 30 requests/min per user) to prevent system abuse.
- **Data Persistence**: Immutable audit logs for compliance following initial submission.
- **Responsive Interface**: Full functionality across mobile and desktop environments.

