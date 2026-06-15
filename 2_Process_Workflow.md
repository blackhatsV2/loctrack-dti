[← Back to README](README.md) | [← Previous: Project Overview](1_Project_Overview.md) | [Next: Functional Requirements →](3_Functional_Requirements.md)

# Process Workflow: Preparedness, Safety & Continuity Portal: Workforce Locator

This document describes the operational sequences for employees and administrators.

## 1. Authentication

1.  **Login**: User navigates to the login page and enters their email (or full name in "Firstname Lastname" format) and password.
2.  **Role-Based Redirect**: On successful authentication, admins are redirected to `/admin/dashboard` and employees to `/dashboard`.
3.  **Logout**: Session is invalidated and the user is redirected to the welcome page.

## 2. Employee Workflow

### A. Dashboard & Disaster Awareness
1.  **Dashboard View**: After login, the employee sees the Disaster Tracker Dashboard with a "Total Location Logs" card (links to their history page), a profile mini-card, and a three-panel map layout.
2.  **Map Interaction**: The left sidebar shows the employee's own layer on the map. The right sidebar lists live hazards (USGS earthquakes and NASA events) with filter pills (All / USGS / NASA). Static overlays for active faults and volcanoes can be toggled.
3.  **Nearest Disaster**: The system can calculate the nearest disaster to the employee's last known position.

### B. Location Reporting
1.  **GPS Submission**: The employee clicks a reporting button. The browser requests Geolocation API permission, captures latitude and longitude, and POSTs to `/api/location`.
2.  **Data Captured**: `user_id`, `latitude`, `longitude`, `recorded_at` (server timestamp), plus carried-forward metadata from the latest record (`address`, `office`, `employee_id_no`, `mobile_no`, `employee_type`).
3.  **Location Broadcast**: An alternate endpoint (`/api/broadcast`) captures coordinates with a `type` of `broadcast`.
4.  **Location Reuse**: From the history page, an employee can reuse a past location entry, creating a new record with the current timestamp.

### C. Address & Profile Management
1.  **Home/Office Address Update**: The employee navigates to the Geography page (`/geography`), enters an address with coordinates, and selects `home` or `office` type. The system creates a new location record.
2.  **Profile Update**: The employee can update their name, email, employee ID, mobile number, office, and employee type via an AJAX form. Changes are synced to the latest location record.
3.  **Password Change**: The employee can change their password (requires current password, new password must differ).

### D. Location History
1.  The employee views their own paginated history at `/history`, showing all past location logs with timestamps and addresses.

## 3. Admin Workflow

### A. Command Center Dashboard
1.  **Statistics Card**: Shows "Total Personnel" count (links to the employee directory page).
2.  **Three-Panel Map**: Left sidebar has employee layers with a search bar and category checkboxes (NC Negros Occidental, NC Iloilo, NC Guimaras, NC Capiz, NC Antique, NC Aklan, DTI6 Regular Employees). A "Personnel Directory" section lists employees with expandable Home/Office/Latest location cards that focus the map on click. The center panel is a Leaflet.js map with Standard/Satellite tile options. The right sidebar lists live hazards with USGS/NASA filter pills and toggleable static layers (Active Faults PH, Volcanoes PH).
3.  **Sync Hazards**: A button triggers re-fetching of USGS and NASA data and reloading of static GeoJSON layers.
4.  **Online Personnel**: Below the map, a section shows employees active in the last 24 hours. This auto-refreshes every 30 seconds via AJAX polling.

### B. Employee Directory Management
1.  **Employee List**: At `/admin/employees`, a searchable and filterable table lists all non-admin employees with Name, Email, ID No., Office, and Mobile columns. Filtering is instant client-side by name/email/ID/mobile text search and office dropdown.
2.  **Add Employee**: Clicking "Add Employee" opens a modal form with fields for Name, Email, ID No., Employee Type (searchable dropdown with "Others" custom input), Address, Mobile, Office (searchable dropdown with "Others" custom input), Latitude, and Longitude. Coordinates default to the selected office's known location if not provided. A loading overlay appears during submission.
3.  **Edit Employee**: Each employee row has an "Edit" link leading to `/admin/employees/{user}/edit` with a full-page form to update all fields.
4.  **Delete Employee**: Each row has a "Delete" button that opens a confirmation modal. Deletion cascades to all location records.

### C. Location History Auditing
1.  **View History**: Each employee row has a "History" link to `/admin/employees/{user}/history` showing paginated location logs.
2.  **Delete Individual Log**: Each log entry can be deleted individually via a DELETE request.
3.  **Bulk Delete**: Admins can select specific logs and delete them in batch, or clear all history for a user.

### D. Workforce Geography
1.  **Analytics View**: At `/admin/workforce`, admins see office distribution and employee type distribution data, an interactive map with all employees' latest locations, and synchronized data lists with filtering by office and employee type.

### E. Admin Profile
1.  Admins can update their own name, email, and password at `/admin/profile`.

## 4. System Data Flow

1.  **Frontend Capture**: Browser Geolocation API captures GPS coordinates.
2.  **API Layer (Laravel)**: `LocationController@store` validates input and persists the record. Rate limited to 30 requests per minute per user.
3.  **External Data Sync**: `DisasterController` fetches earthquake data from USGS and natural events from NASA EONET v3 on demand (triggered by "Sync Hazards" button).
4.  **Static Data**: Philippine fault lines and volcano locations loaded from local GeoJSON files in `/public/maps/`. KMZ files also served from `/public/maps/`.
5.  **Database Persistence**: Location data stored in `employee_locations` table. Dashboard statistics cached for 5 minutes. Admin IDs cached for 10 minutes. Dropdown options cached for 10 minutes.
6.  **Visualization**: Leaflet.js renders the map with employee markers, hazard markers, and GeoJSON overlays. Chart.js renders distribution charts on the workforce page.
