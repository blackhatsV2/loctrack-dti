[← Back to README](README.md) | [← Previous: Deployment Guide](6_Deployment_Guide.md) | [Next: VAPT Report →](8_VAPT_Report.md)

# User Manual: Preparedness, Safety & Continuity Portal: Workforce Locator

---

## 1. Logging In

1.  Navigate to the application URL.
2.  Enter your **email address** or **full name** (in "Firstname Lastname" format) and your **password**.
3.  Click **Login**. You will be redirected to your role-specific dashboard.

---

## 2. Employee Dashboard

After logging in, employees see the **Disaster Tracker Dashboard**.

### Dashboard Cards
- **Total Location Logs**: Shows the count of all your location submissions. Click this card to go directly to your **Location History** page.
- **Profile Card**: Shows your name, email, and employee type. Click **"Manage Profile"** to go to the Geography page where you can edit your profile and addresses.

### Map Interface
The dashboard uses a three-panel layout:

- **Left Sidebar (Personnel Layers)**: Shows your own location marker on the map with a visibility toggle.
- **Center (Map)**: A Leaflet.js map centered on the Philippines. Toggle between Standard and Satellite views using the layer control in the top-left corner.
- **Right Sidebar (Hazard Monitoring)**: Lists live hazard events. Use the **All / USGS / NASA** filter pills to filter by source. Toggle **Active Faults** and **Volcanoes** overlays at the bottom.

### Map Controls
- **Sync Data**: Click the 🔄 button to re-fetch the latest earthquake and NASA event data.
- **Recenter PH**: Click 📍 to re-center the map on the Philippines.

---

## 3. Reporting Your Location

1.  When prompted, **Allow** your browser to access your location.
2.  Click the location reporting button on the dashboard.
3.  The system captures your GPS coordinates and creates a new location record with the current timestamp.

---

## 4. Managing Your Profile & Addresses

Navigate to the **Geography** page (via "Manage Profile" on the dashboard or the `/geography` route).

### Update Home Address
1.  Enter your home address and coordinates.
2.  Select **"Home"** as the type.
3.  Submit. A new location record is created with `type = home`.

### Update Office Location
1.  Enter your office name and coordinates.
2.  Select **"Office"** as the type.
3.  Submit. A new location record is created with `type = office`.

### Edit Profile
- Update your **Name**, **Email**, **Employee ID**, **Mobile Number**, **Office**, and **Employee Type**.
- Changes are saved via AJAX and synced to your latest location record.

### Change Password
- Enter your current password, a new password (minimum 8 characters, must differ from current), and confirm.

---

## 5. Viewing Your Location History

1.  Navigate to `/history` (or click the "Total Location Logs" card on the dashboard).
2.  Your past location entries are displayed in a paginated table, most recent first.
3.  You can **reuse** a past location by clicking the reuse button, which creates a new entry with the current timestamp using the same coordinates and metadata.

---

## 6. Admin Dashboard

After logging in as an admin, you see the **Admin Dashboard**.

### Statistics
- **Total Personnel**: Shows the count of non-admin employees. Click the card to go to the Employee Directory.

### Command Center Map
A three-panel layout:

- **Left Sidebar (Employee Layers)**:
    - **Search Bar**: Type to filter employees on the map in real-time by name or office.
    - **Category Checkboxes**: Toggle visibility of employee groups (NC Negros Occidental, NC Iloilo, NC Guimaras, NC Capiz, NC Antique, NC Aklan, DTI6 Regular Employees). Each shows a count.
    - **Personnel Directory**: Scrollable list of employees with expandable Home 🏠, Office 🏢, and Latest Activity 📍 location cards. Click a card to fly the map to that location and open its popup.
    - **Show All / Hide All**: Buttons to toggle all employee categories at once.
- **Center (Map)**: Leaflet.js map with Standard/Satellite toggle, color-coded employee markers, earthquake circle markers (sized by magnitude), and NASA event markers.
- **Right Sidebar (Global Hazards)**:
    - **Filter Pills**: All / USGS / NASA to filter the hazard list and map markers.
    - **Hazard Cards**: Click any card to fly the map to that location.
    - **Static Layers**: Toggle Active Faults (PH) and Volcanoes (PH) overlays.
- **Sync Hazards**: Click 🔄 to re-fetch USGS and NASA data.
- **Recenter PH**: Click 📍 to recenter the map on the Philippines.

### Online Personnel
Below the map, a section lists employees active within the last 24 hours. This refreshes automatically every 30 seconds.

### Responsive Behavior
On smaller screens (≤1200px), the three-panel layout stacks vertically: Employee Layers on top, then the map, then Global Hazards below.

---

## 7. Managing Employees (Admin)

Navigate to `/admin/employees`.

### Viewing & Searching
- The employee table shows Name/Email, ID No., Office, Mobile, and action links.
- Use the **search bar** to filter by name, email, ID, or mobile number. Results update instantly.
- Use the **office dropdown** to filter by a specific office.
- Click **Clear** to reset all filters.

### Adding an Employee
1.  Click **"➕ Add Employee"**.
2.  Fill in the form: Name (required), Email (required), ID No., Employee Type (searchable dropdown), Address, Mobile, Office (searchable dropdown), Latitude, Longitude.
3.  If coordinates are not provided, they default to the selected office's known location.
4.  Click **"Create Account"**. A loading overlay appears during submission. The default password for new accounts is `password123`.

### Editing an Employee
1.  Click **"Edit"** on the employee's row.
2.  Update any fields on the edit page.
3.  Click save to apply changes.

### Deleting an Employee
1.  Click **"Delete"** on the employee's row.
2.  A confirmation modal appears showing the employee's name and warning that all location history will be deleted.
3.  Click **"Delete Account"** to confirm.

---

## 8. Viewing & Managing Location History (Admin)

1.  From the employee directory, click **"History"** on any employee's row.
2.  The paginated history shows all location entries for that employee (most recent first).
3.  **Delete Individual**: Delete a single log entry.
4.  **Delete Selected**: Select multiple entries and delete them in batch.
5.  **Clear All**: Delete all location history for that employee.

---

## 9. Workforce Geography (Admin)

Navigate to `/admin/workforce`.

- View latest employee locations plotted on an interactive map.
- See office distribution and employee type distribution analytics.
- Filter and interact with synchronized data lists.

---

## Troubleshooting & FAQ

- **"Location access denied"**: Check your browser and device privacy settings. Ensure the site has permission to access GPS.
- **Map not loading**: This may occur during heavy data synchronization. Click "Sync Data" or refresh the page.
- **Stale disaster data**: Click the "Sync Hazards" button to re-fetch the latest data from USGS and NASA.
- **GPS accuracy**: Precision can be affected by indoor environments, high-density urban areas, or VPN usage.
- **Employee not appearing on map**: Ensure the employee has at least one location record. New employees added without coordinates will have their position set to their assigned office location.
