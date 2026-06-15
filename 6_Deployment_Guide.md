[← Back to README](README.md) | [← Previous: Database Documentation](5_Database_Documentation.md) | [Next: User Manual →](7_User_Manual.md)

# Deployment Guide: Preparedness, Safety & Continuity Portal: Workforce Locator

## Prerequisites
- **Local Environment**: PHP 8.2+, Composer, Node.js & NPM, MySQL.
- **Docker**: Optional but recommended (uses Laravel Sail).

## Deployment Options

### 1. Docker Deployment (Laravel Sail)
1.  **Clone**: `git clone <repository-url>`
2.  **Install Dependencies**:
    ```bash
    docker run --rm -v "$(pwd):/var/www/html" -w /var/www/html laravelsail/php82-composer:latest composer install
    ```
3.  **Environment**: `cp .env.example .env` and configure database credentials.
4.  **Start Sail**: `./vendor/bin/sail up -d`
5.  **Initialize**:
    ```bash
    ./vendor/bin/sail artisan key:generate
    ./vendor/bin/sail artisan migrate --seed
    ./vendor/bin/sail npm install
    ./vendor/bin/sail npm run build
    ```

### 2. Manual Local Setup
1.  **Install**: `composer install`
2.  **Environment**: `cp .env.example .env` and update `DB_*` variables.
3.  **Initialize**:
    ```bash
    php artisan key:generate
    php artisan migrate --seed
    npm install
    npm run build
    php artisan serve
    ```

### 3. Cloud-Native / PaaS (e.g., Northflank)
The system supports **Nixpacks** detection for automated builds.

1.  Connect the repository.
2.  Define **Environment Variables**:
    *   `APP_KEY`, `APP_ENV`, `APP_URL`
    *   `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
3.  The build process will automatically handle `composer install` and `npm install`.

## Default Accounts
After running `php artisan migrate --seed`:
- **Admin**: `admin@dti6.gov.ph` / `admin123`
- **Employees**: Imported from the `EmployeeLocationSeeder` with default password `password123`.

## Post-Deployment Commands
```bash
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Environment Variables
Key `.env` variables used by the application:
- `APP_KEY` — Application encryption key.
- `APP_ENV` — `local` or `production`.
- `APP_URL` — Base URL of the application.
- `DB_*` — MySQL connection details.
- `FORCE_HTTPS` — Set to `true` in production for SSL enforcement.

## Security & Maintenance
- **SSL**: Force HTTPS in production via `APP_URL` and the `FORCE_HTTPS` variable.
- **Backups**: Regular dumps of the `users` and `employee_locations` tables.
- **Logs**: Monitor `storage/logs/laravel.log` for API errors (USGS/NASA failures, geolocation issues).
- **Cache**: Dashboard stats cached for 5 minutes, admin IDs for 10 minutes, dropdown options for 10 minutes. Clear with `php artisan cache:clear` if stale data is observed.
