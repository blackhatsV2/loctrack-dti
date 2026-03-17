# Deployment Guide

This document provides instructions for deploying the Employee Location Tracking System.

## Prerequisites
- **Docker**: For containerized environments.
- **Nixpacks**: For automatic build configuration.
- **PHP 8.2+**: If running locally without Docker.
- **Composer**: For dependency management.
- **Database**: PostgreSQL or MySQL instance.

## Deployment Options

### 1. Docker Deployment (Recommended)
The repository includes a `Dockerfile` for standardized deployment.

1.  **Clone the repository**:
    ```bash
    git clone <repository_url>
    cd employee_locs
    ```
2.  **Configure environment**:
    ```bash
    cp .env.example .env
    # Edit .env with production database credentials and APP_KEY
    ```
3.  **Build and Run**:
    ```bash
    docker build -t loctrack .
    docker run -p 80:80 loctrack
    ```

### 2. PaaS Deployment (e.g., Northflank/Render)
The project is configured for PaaS detection via `nixpacks.toml`.

1.  Connect your Git repository to the platform.
2.  Set the following **Environment Variables**:
    *   `APP_KEY`: Base64 generated Laravel key.
    *   `DB_CONNECTION`: e.g., `pgsql`
    *   `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
3.  The build system will automatically detect the Laravel environment and run migrations.

## Post-Deployment Steps
After the initial deployment, ensure the following commands are executed (automated in most CI/CD pipelines):

```bash
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Maintenance
- **Backups**: Ensure regular backups of the location data in the database.
- **Logs**: Monitor storage logs via `storage/logs/laravel.log`.
- **Throttling**: Adjust API rate limits in `routes/web.php` if high traffic is expected.
