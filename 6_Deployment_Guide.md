[← Back to README](README.md) | [← Previous: Database Documentation](5_Database_Documentation.md) | [Next: User Manual →](7_User_Manual.md)

# Deployment Guide: Loctrack DTI

This document provides instructions for deploying the Employee Location Tracking System.

## Prerequisites
- **Local Environment**: PHP 8.2+, Composer, Node.js & NPM, MySQL.
- **Docker**: Optional but recommended (uses Laravel Sail).

## Deployment Options

### 1. Docker Deployment (Laravel Sail)
1.  **Clone**: `git clone https://github.com/blackhatsV1/loctrack-dti`
2.  **Environment**: `cp .env.example .env`
3.  **Start Sail**: `./vendor/bin/sail up -d`
4.  **Initialize**:
    ```bash
    ./vendor/bin/sail artisan migrate --seed
    ./vendor/bin/sail npm run build
    ```

### 2. Cloud-Native / PaaS (e.g., Northflank)
The system is optimized for **Nixpacks** detection.

1.  Connect the `loctrack-dti` repository.
2.  Define **Environment Variables**:
    *   `APP_KEY`, `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
3.  The build process will automatically handle `composer install` and `npm install`.

## Post-Deployment Hooks
Ensure the following are run in production:

```bash
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Security & Maintenance
- **SSL**: Force HTTPS in production `APP_URL`.
- **Backups**: Regular dumps of the `employee_locations` table.
- **Logs**: Monitor `storage/logs/laravel.log` for geolocation failures.

