[← Back to README](README.md) | [← Previous: Project Plan](10_Project_Plan.md)

# Project Modules: Preparedness, Safety & Continuity Portal: Workforce Locator

The Preparedness, Safety & Continuity Portal: Workforce Locator is organized into several key functional modules that work together to provide real-time monitoring and hazard response.

## 1. Authentication & Identity Module
- **Core Security**: Handles user login, registration, and secure session management.
- **RBAC (Role-Based Access Control)**: Strictly separates **Employee** (reporting) and **Admin** (monitoring) permissions.
- **Profile Management**: Allows users to maintain their contact details, office assignments, and employment status.

## 2. Real-time Telemetry & Tracking Module
- **GPS Capture Engine**: Utilizes the HTML5 Geolocation API to capture high-precision coordinates.
- **Reverse-Geocoding Service**: Automatically translates raw coordinates into human-readable physical addresses.
- **Throttled Reporting API**: A secure REST endpoint (`/api/location`) with rate limiting (30 req/min) to ensure system stability.
- **Contextual Logging**: Captures check-in metadata, including location type (Home/Office) and device telemetry.

## 3. Unified Command Center (Admin)
- **Interactive Fleet Map**: A Leaflet.js-powered map plotting the entire active workforce in real-time.
- **Hazard Integration**: Synchronizes employee positions with live disaster markers (Earthquakes, NASA events).
- **Dynamic Layer Engine**: Supports toggling between Base Maps, Active Fault Lines, Volcano Locations, and KMZ/KML hazard data.
- **Real-time Stats Dashboard**: High-level overview of total personnel online, distribution charts (Chart.js), and latest activity feeds.

## 4. Disaster & Hazard Tracking Module
- **USGS Integration**: Automated fetching and rendering of global Earthquake data.
- **NASA EONET Integration**: Tracking of natural events such as wildfires, storms, and floods via NASA's API.
- **Geospatial Asset Management**: Serving and rendering specialized map data (KMZ files) for environmental risk analysis.

## 5. Workforce Geography & Spatial Analysis
- **Distribution Analysis**: Dedicated module for visualizing the density of Home vs. Office-based employees.
- **Synchronized Interaction**: Cross-list highlighting where selecting an employee in the list focuses them on the map and vice versa.
- **Solo Marker Highlighting**: Prominent visualization for individual personnel during auditing or emergency tracking.

## 6. Audit & History Module
- **Immutable Track Logs**: Comprehensive, time-stamped history of all location reports for every user.
- **Movement Pattern Analysis**: Allows admins to drill down into historical data to verify compliance and safety protocols.
- **Search & Filter Engine**: Advanced filtering of logs by date range, department, employee type, or office location.

## 7. Performance & Optimization Layer
- **Responsive UI/UX**: Built with Tailwind CSS v4 for a premium experience on both mobile check-in terminals and desktop command centers.
- **Instant Transitions**: Uses skeleton loaders and optimized database indexes to ensure near-zero latency during page navigation.
- **Asset Orchestration**: Powered by Vite 7 for fast, modern frontend delivery.
