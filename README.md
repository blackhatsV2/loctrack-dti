# Preparedness, Safety & Continuity Portal: Workforce Locator

A premium, real-time location monitoring and disaster response management system. Built with Laravel 12, Tailwind CSS v4, and integrated with live hazard data from USGS and NASA.

---

### 🧭 Quick Navigation

| Section | Description |
| :--- | :--- |
| [📚 Documentation](#-documentation) | Project docs (Overview, Architecture, VAPT, etc.) |
| [🚀 Getting Started](#-getting-started) | Docker & Manual setup instructions |
| [📊 Data Management](#-data-management) | Seeders and data handling |
| [🛠 Tech Stack](#-tech-stack) | Technologies used |
| [📄 License](#-license) | MIT License |

---

## 📚 Documentation

Explore the project's documentation to understand the architecture, features, and deployment procedures:

- 📖 [1. Project Overview](1_Project_Overview.md) - High-level goals and key features.
- ⚙️ [2. Process Workflow](2_Process_Workflow.md) - User and system operational sequences.
- 📋 [3. Functional Requirements](3_Functional_Requirements.md) - Detailed feature specifications.
- 🏗️ [4. System Architecture](4_System_Architecture.md) - Tech stack and component design.
- 🗄️ [5. Database Documentation](5_Database_Documentation.md) - Schema and index details.
- 🚀 [6. Deployment Guide](6_Deployment_Guide.md) - Production and local setup instructions.
- 📘 [7. User Manual](7_User_Manual.md) - Step-by-step usage guide.
- 🛡️ [8. VAPT Report](8_VAPT_Report.md) - Security assessment and mitigations.
- 📊 [9. Presentation Deck](9_Presentation.md) - Project summary slides.
- 🗺️ [10. Master Project Plan / Roadmap](10_Project_Plan.md) - Strategic roadmap and status.
- 🧩 [11. Project Modules](11_Project_Modules.md) - Detailed functional breakdown.

---

## 🚀 Getting Started

### Option 1: Docker Setup (Recommended)

Uses [Laravel Sail](https://laravel.com/docs/sail) for a containerized environment.

1. **Clone & Install**:
   ```bash
   git clone https://github.com/blackhatsV1/loctrack-dti
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

## 🛠 Tech Stack
- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Tailwind CSS v4, Alpine.js, Blade
- **Maps**: Leaflet.js (Integrated with USGS Earthquakes & NASA EONET)
- **Charts**: Chart.js for spatial distribution analysis
- **Database**: MySQL 8.0 (Optimized with time-series indexing)
- **Asset Bundling**: Vite 7

---

## 📄 License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
