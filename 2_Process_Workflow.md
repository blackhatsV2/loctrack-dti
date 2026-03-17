# Process Workflow: Employee Location Tracking

This document outlines the operational sequences for different types of users within the system.

## 1. Employee Workflow: Location Reporting

The primary action for employees is reporting their location.

1.  **Authentication**: Employee logs into the application using their credentials.
2.  **Dashboard Access**: Employee is directed to the user dashboard.
3.  **Location Acquisition**: The browser/device requests permission to access high-accuracy GPS coordinates.
4.  **Data Submission**: The employee confirms submission. The system captures:
    *   Latitude & Longitude
    *   Timestamp (`recorded_at`)
    *   Device-derived Address (via reverse geocoding if enabled)
5.  **Confirmation**: The system provides immediate feedback upon successful submission.

## 2. Admin Workflow: Monitoring and Management

Admins have a broader set of workflows for oversight.

### A. Real-time Monitoring
1.  **Dashboard Overview**: View summaries of recent activity and active employees.
2.  **Map Visualization**: Access the Live Map to see the current distribution of employees.
3.  **Detail Drill-down**: Click on markers or list items to view specific employee details.

### B. Employee Management
1.  **User List**: Browse all registered employees.
2.  **Profile Editing**: Update employee information (ID Number, Mobile, Office, Type).
3.  **Access Control**: Manage user roles and administrative privileges.

### C. Historical Auditing
1.  **History Access**: Navigate to a specific employee's location history.
2.  **Reviewing Logs**: Analyze past movements, timestamps, and reported addresses for compliance or logistical planning.

## 3. System Data Flow

1.  **Frontend (Client)**: Captures user input and geolocation data.
2.  **API Layer (Controller)**: Handles the request, applies rate limiting (throttling), and validates data.
3.  **Database Layer (Model/Eloquent)**: Persists the location record in the `employee_locations` table.
4.  **Reverse Geocoding (Optional/Service)**: Background or client-side service translates coordinates into readable addresses.
