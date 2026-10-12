# -------------------------------------------------------------
# Stage 1: Build frontend assets (Vite / Tailwind)
# -------------------------------------------------------------
FROM node:20-alpine AS build-assets

WORKDIR /app

COPY package.json ./
RUN npm install

COPY . .
RUN npm run build

# -------------------------------------------------------------
# Stage 2: Production PHP + Apache Application
# -------------------------------------------------------------
FROM php:8.3-apache

# Install required system packages and PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    libzip-dev \
    libpq-dev \
    libsqlite3-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    pdo_sqlite \
    bcmath \
    zip \
    opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Configure Apache DocumentRoot to point to Laravel's public directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && a2enmod rewrite

# Copy project files
COPY . .

# Copy compiled frontend assets from Stage 1
COPY --from=build-assets /app/public/build ./public/build

# Install production PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Set appropriate directory permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Render automatically provides $PORT (defaulting to 10000 on Render, or 80 locally)
EXPOSE 80

# Configure port dynamically on startup, run optimizations, and start Apache
CMD ["sh", "-c", "sed -i \"s/Listen 80/Listen ${PORT:-80}/\" /etc/apache2/ports.conf && sed -i \"s/:80/:${PORT:-80}/\" /etc/apache2/sites-available/*.conf && if [ -n \"$APP_KEY\" ]; then php artisan config:cache || true; php artisan route:cache || true; php artisan view:cache || true; fi && apache2-foreground"]
