[← Back to README](README.md) | [← Previous: Project Overview](1_Project_Overview.md) | [Next: Functional Requirements →](3_Functional_Requirements.md)

# Process Workflow: Preparedness, Safety & Continuity Portal: Workforce Locator

This document outlines the operational sequences for different types of users within the Preparedness, Safety & Continuity Portal: Workforce Locator system.

## 1. Employee Workflow: Location Reporting

The primary action for field staff is reporting their current location.

1.  **Authentication**: Employee logs into the application using their credentials.
2.  **Dashboard Access**: Employee is directed to the mobile-responsive user dashboard.
3.  **Location Acquisition**: The browser/device requests permission to access GPS coordinates.
4.  **Confirm Submission**: The employee clicks the reporting button. The system captures:
    *   Latitude & Longitude
    *   Timestamp (`recorded_at`)
    *   Reverse-Geocoded Address (automatically determined)
    *   Type (Home/Office selection)
5.  **Success Feedback**: The system provides immediate confirmation upon successful submission.

## 2. Admin Workflow: Monitoring and Management

Administrators maintain oversight through a centralized command center.

### A. Unified Command & Hazard Monitoring
1.  **Dashboard Overview**: View real-time workforce statistics and active disaster alerts (Earthquakes/NASA Events).
2.  **Interactive Map Navigation**:
    *   **Layer Toggling**: Switch between active faults, volcano locations, and KMZ disaster layers.
    *   **Hazard Correlation**: Identify employees within proximity to live disaster markers.
3.  **Dynamic Filtering**: Filter map view by office location, employee type, or disaster risk level.

### B. User & History Management
1.  **Employee Directory**: Manage the list of registered users and their profile details (Office, Employee Type).
2.  **Historical Auditing**: Review per-employee movement history with detailed timestamp and address logs.
3.  **Workforce Geography Analysis**: Utilize the geography dashboard to analyze Home vs. Office distribution density with synchronized map views.

## 3. System Data Flow

1.  **Frontend Capture**: Captures Geolocation API data via the browser.
2.  **API Layer (Laravel)**: Processes the request, applies rate limiting, and validates input.
3.  **External Data Sync**: Periodically fetches live disaster data from USGS and NASA APIs.
4.  **Database Persistence**: Stores tracking data in `employee_locations` and hazard data in cache/temporary storage.
5.  **Admin Visualization**: Renders interactive map and history views using Leaflet.js and Chart.js.
