[← Back to README](README.md) | [← Previous: Project Overview](1_Project_Overview.md) | [Next: Functional Requirements →](3_Functional_Requirements.md)

# Process Workflow: Employee Location Tracking

This document outlines the operational sequences for different types of users within the Employee Location Tracking System.

## 1. Employee Workflow: Location Reporting

The primary action for field staff is reporting their current location.

1.  **Authentication**: Employee logs into the application using their credentials.
2.  **Dashboard Access**: Employee is directed to the mobile-responsive user dashboard.
3.  **Location Acquisition**: The browser/device requests permission to access GPS coordinates.
4.  **Confirm Submission**: The employee clicks the reporting button. The system captures:
    *   Latitude & Longitude
    *   Timestamp (`recorded_at`)
    *   Reverse-Geocoded Address (automatically determined)
5.  **Success Feedback**: The system provides immediate confirmation upon successful submission.

## 2. Admin Workflow: Monitoring and Management

Administrators maintain oversight through a centralized command center.

### A. Real-time Monitoring
1.  **Command Center Overview**: View total active employees and recent reporting activity.
2.  **Live Map Visualization**: Access the interactive map to see the current geographical distribution of staff.
3.  **Detail Review**: Click on map markers or list items to view specific employee status.

### B. User & History Management
1.  **Employee Directory**: Manage the list of registered users and their profiles.
2.  **Historical Auditing**: Navigate to specific employee logs to review movement history and compliance.
3.  **Data Export**: (Optional) Generate reports for offline review or archiving.

## 3. System Data Flow

1.  **Frontend Capture**: Captures Geolocation API data via the browser.
2.  **API Layer (Laravel)**: Processes the request, applies rate limiting, and validates input.
3.  **Database Persistence**: Stores tracking data in the `employee_locations` table.
4.  **Admin Visualization**: Renders interactive map and history views for management oversight.


