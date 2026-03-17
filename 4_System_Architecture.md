# System Architecture

This document describes the high-level architecture and technology stack of the Employee Location Tracking System.

## Architecture Pattern
The application follows the **Model-View-Controller (MVC)** architectural pattern, inherent to the Laravel framework.

- **Model**: Eloquent ORM classes (e.g., `User`, `EmployeeLocation`) handle data logic and database interactions.
- **View**: Blade templates provide the user interface for both regular staff and administrators.
- **Controller**: Logic handlers (e.g., `LocationController`, `AdminController`) manage input, interact with models, and return views or API responses.

## Technology Stack

### Backend
- **Framework**: Laravel (PHP)
- **Database**: Relational Database (typically PostgreSQL or MySQL/MariaDB)
- **Web Server**: NGINX (standard with Laravel-optimized Docker images)

### Frontend
- **Languages**: HTML5, CSS3, JavaScript
- **Templating**: Blade Templating Engine
- **Vite**: Modern frontend build tool for asset bundling and hot module replacement.

### Deployment & Infrastructure
- **Containerization**: Docker (via `Dockerfile`)
- **Build System**: Nixpacks (via `nixpacks.toml`)
- **Hosting**: Cloud-native (e.g., Northflank or similar PaaS)

## Key Components

### 1. Geolocation API
A RESTful endpoint (`/api/location`) that accepts JSON payloads containing GPS coordinates. It uses Laravel's built-in throttling to ensure system stability.

### 2. Admin Management Layer
Protected by custom middleware (`AdminMiddleware`), this layer provides restricted access to sensitive employee data and system configurations.

### 3. Integrated Mapping
The application integrates with map providers (e.g., Leaflet or Google Maps via Blade views) to plot employee coordinates on an interactive canvas.

### 4. Background Processing (Optional)
Utilizes Laravel's Queue system (documented in `README.md`) for decoupled tasks, although core tracking is handled synchronously for immediate feedback.

## Data Flow Diagram (Conceptual)
Employee Device -> HTTPS POST -> Laravel Router -> Controller -> Data Validation -> DB Persistence -> Admin Dashboard Visualization
