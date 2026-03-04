FROM php:8.4-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    libsqlite3-dev \
    libcurl4-openssl-dev \
    libssl-dev \
    zip \
    unzip \
    curl \
    git \
    nodejs \
    npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl xml opcache

# Copy custom OPCache configuration
COPY storage/conf/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Set Composer environment variables
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_MEMORY_LIMIT=-1

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory contents
COPY . /var/www/html

# Install Composer dependencies (no dev, no scripts to avoid boot errors)
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev --no-scripts --verbose

# Set Apache document root to public/
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Enable Apache mod_rewrite and mod_deflate
RUN a2enmod rewrite deflate

# Add Gzip configuration
RUN echo '<IfModule mod_deflate.c>\n\
    AddOutputFilterByType DEFLATE text/plain\n\
    AddOutputFilterByType DEFLATE text/html\n\
    AddOutputFilterByType DEFLATE text/xml\n\
    AddOutputFilterByType DEFLATE text/css\n\
    AddOutputFilterByType DEFLATE application/xml\n\
    AddOutputFilterByType DEFLATE application/xhtml+xml\n\
    AddOutputFilterByType DEFLATE application/rss+xml\n\
    AddOutputFilterByType DEFLATE application/javascript\n\
    AddOutputFilterByType DEFLATE application/x-javascript\n\
    AddOutputFilterByType DEFLATE application/json\n\
</IfModule>' >> /etc/apache2/apache2.conf

# Build assets
RUN npm install && npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
