FROM php:8.1-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions (including zip for Composer)
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy PHP configuration FIRST (before composer install)
COPY docker/php/composer.ini /usr/local/etc/php/conf.d/composer.ini

# Copy composer files first for better caching
COPY composer.json composer.lock /var/www/html/

# Install composer dependencies (before copying all files)
RUN composer install --optimize-autoloader --no-dev --no-interaction --no-scripts

# Copy existing application directory contents
COPY . /var/www/html

# Run composer scripts after all files are copied (while composer.ini is still active)
RUN composer dump-autoload --optimize

# Enable Apache modules
RUN a2enmod rewrite headers expires

# Set ServerName globally to suppress warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy Apache configuration
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Copy PHP configuration for runtime (this will override composer.ini with secure settings)
COPY docker/php/local.ini /usr/local/etc/php/conf.d/local.ini

# Create necessary directories and set permissions
RUN mkdir -p /var/www/html/storage/framework/cache \
    && mkdir -p /var/www/html/storage/framework/sessions \
    && mkdir -p /var/www/html/storage/framework/views \
    && mkdir -p /var/www/html/storage/logs \
    && mkdir -p /var/www/html/bootstrap/cache

# Set proper ownership and permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache \
    && chmod -R 644 /var/www/html/.env 2>/dev/null || true

# Security: Remove sensitive files
RUN rm -f /var/www/html/.env.example \
    && rm -rf /var/www/html/tests

# Expose port 80
EXPOSE 80

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=40s --retries=3 \
    CMD curl -f http://localhost/health || exit 1

# Start Apache
CMD ["apache2-foreground"]
