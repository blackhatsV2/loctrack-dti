# Preparedness, Safety & Continuity Portal: Workforce Locator

A real-time location monitoring and disaster awareness system for the Department of Trade and Industry (DTI) Region 6. Built with Laravel 12, it maps employee positions alongside live earthquake and natural event data on an interactive Leaflet.js dashboard.

---

### Quick Navigation

| Section | Description |
| :--- | :--- |
| [Documentation](#documentation) | Project docs (Overview, Architecture, VAPT, etc.) |
| [Getting Started](#getting-started) | Docker & Manual setup instructions |
| [Data Management](#data-management) | Seeders and data handling |
| [Tech Stack](#tech-stack) | Technologies used |
| [License](#license) | MIT License |

---

## Documentation

- [1. Project Overview](1_Project_Overview.md) - System purpose, key features, and target audience.
- [2. Process Workflow](2_Process_Workflow.md) - User and admin operational sequences.
- [3. Functional Requirements](3_Functional_Requirements.md) - Detailed feature specifications.
- [4. System Architecture](4_System_Architecture.md) - Tech stack, MVC pattern, and component design.
- [5. Database Documentation](5_Database_Documentation.md) - Schema, columns, and index details.
- [6. Deployment Guide](6_Deployment_Guide.md) - Production and local setup instructions.
- [7. User Manual](7_User_Manual.md) - Step-by-step usage guide for employees and admins.
- [8. VAPT Report](8_VAPT_Report.md) - Security assessment and mitigations.
- [9. Presentation Deck](9_Presentation.md) - Project summary slides.
- [10. Master Project Plan](10_Project_Plan.md) - Development roadmap and status.
- [11. Project Modules](11_Project_Modules.md) - Detailed functional module breakdown.

---

## Getting Started

### Option 1: Docker Setup (Recommended)

Uses [Laravel Sail](https://laravel.com/docs/sail) for a containerized environment.

1. **Clone & Install**:
   ```bash
   git clone <repository-url>
   cd loctrack-dti
   docker run --rm -v "$(pwd):/var/www/html" -w /var/www/html laravelsail/php82-composer:latest composer install
   ```

2. **Initialize**:
   ```bash
   cp .env.example .env
   ./vendor/bin/sail up -d
   ./vendor/bin/sail artisan key:generate
   ./vendor/bin/sail artisan migrate --seed
   ./vendor/bin/sail npm install
   ./vendor/bin/sail npm run build
   ```

### Option 2: Manual Local Setup

1. **Environment**: Ensure PHP 8.2+, Composer, Node.js, and MySQL are installed.
2. **Setup**:
   ```bash
   composer install
   cp .env.example .env # Update DB credentials
   php artisan key:generate
   php artisan migrate --seed
   npm install
   npm run build
   php artisan serve
   ```

---

## Data Management

The `DatabaseSeeder` creates a default admin account (`admin@dti6.gov.ph`) and imports employee location data from the `EmployeeLocationSeeder`.

---

## Tech Stack
- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Tailwind CSS v4, Alpine.js, Blade Templates
- **Maps**: Leaflet.js with Leaflet.MarkerCluster
- **Charts**: Chart.js
- **Database**: MySQL (with performance indexes on `employee_locations`)
- **External APIs**: USGS Earthquake API, NASA EONET v3 API
- **Static Map Data**: Philippine Active Faults (GeoJSON), Philippine Volcanoes (GeoJSON), KMZ hazard files
- **Asset Bundling**: Vite 7

---

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
