[← Back to README](README.md) | [Next: Process Workflow →](2_Process_Workflow.md)

# Project Overview: Preparedness, Safety & Continuity Portal (PSCP): Workforce Locator

## Introduction
The Workforce Locator is a web-based monitoring platform built with Laravel 12 for the Department of Trade and Industry (DTI) Region 6. It plots employee locations on an interactive map alongside live disaster data (earthquakes from USGS, natural events from NASA) so administrators can see where personnel are relative to active hazards.

## Purpose
The system provides a unified dashboard that displays employee positions and environmental hazards on a single map. Administrators can monitor the workforce across DTI Region 6 provincial offices (Aklan, Antique, Capiz, Guimaras, Iloilo, Negros Occidental), manage employee records, and review location history. Employees can report their GPS coordinates and view nearby disaster activity.

## Key Features
- **Admin Command Center**: A three-panel layout (Employee Layers sidebar, Leaflet.js map, Global Hazards sidebar) that plots all employee positions alongside live USGS earthquake markers and NASA natural event markers.
- **Employee Disaster Tracker Dashboard**: A similar three-panel map view for regular employees showing their own location and live hazard data, with a profile card and total location logs count.
- **Live Disaster Data**: Integration with the USGS Earthquake API (past 3 days, M2.5+) and NASA EONET v3 API (open events, limit 50).
- **Static Geospatial Layers**: Toggleable map overlays for Philippine active fault lines and volcano locations loaded from local GeoJSON files, plus KMZ hazard file support.
- **Employee Search & Filtering**: Real-time client-side search by name, email, ID, or mobile on the employee directory. Category-based filtering on the map by employee type (NC Negros Occidental, NC Iloilo, NC Guimaras, NC Capiz, NC Antique, NC Aklan, DTI6 Regular Employees).
- **Employee Management**: Admins can add employees via a modal form, edit employee details on a dedicated page, and delete employee accounts with confirmation.
- **Location Reporting**: Employees submit GPS coordinates via browser Geolocation API. The system stores latitude, longitude, timestamp, and address/office metadata per submission.
- **Location History & Auditing**: Paginated history views for both employees (own history) and admins (any employee's history). Admins can delete individual logs, delete selected logs in bulk, or clear all history for a user.
- **Location Reuse**: Employees can re-submit a past location entry as a new record with the current timestamp.
- **Address & Profile Management**: Employees can update their home address and office location (with coordinates), and edit their profile (name, email, ID, mobile, office, employee type). Admins can also update their own profile.
- **Online Personnel Tracking**: The admin dashboard displays employees active within the last 24 hours, with automatic polling every 30 seconds to refresh the list.
- **Nearest Disaster Notification**: An API endpoint calculates the closest disaster (earthquake or NASA event) to a user's last known location using the Haversine formula. For admins, it also returns a list of disasters within Philippine boundaries.
- **Workforce Geography & Analytics**: A dedicated admin page showing office distribution and employee type distribution, with an interactive map and synchronized data lists.

## Target Audience
- **DTI Region 6 Field & Office Staff**: For reporting their location and viewing nearby hazards.
- **DTI Region 6 Administrators**: For monitoring employee positions, managing the employee directory, and reviewing location history.

## Technical Foundation
Built on **Laravel 12** (PHP 8.2+) with **Tailwind CSS v4**, **Leaflet.js**, **Chart.js**, and **Vite 7**. Uses MySQL with performance-optimized indexes on the `employee_locations` table.
