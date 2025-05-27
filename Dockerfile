FROM php:8.2-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    libonig-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libsodium-dev \
    libpq-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        bcmath \
        exif \
        gd \
        intl \
        pdo_mysql \
        sodium \
        zip \
        opcache \
        pgsql \
        pdo_pgsql \
    && a2enmod rewrite

# Allow symbolic links and .htaccess override in public directory
RUN echo '<Directory /var/www/html/public>' >> /etc/apache2/apache2.conf && \
    echo '    Options +FollowSymLinks' >> /etc/apache2/apache2.conf && \
    echo '    AllowOverride All' >> /etc/apache2/apache2.conf && \
    echo '</Directory>' >> /etc/apache2/apache2.conf

# Set Apache to serve from Laravel's public directory
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory to Apache root
WORKDIR /var/www/html

# Copy application files
COPY . .

# Copy .env example as fallback (Render will inject real vars)
COPY --chown=www-data:www-data .env.example .env

# Set correct permissions
RUN chown -R www-data:www-data storage bootstrap/cache public \
    && chmod -R 775 storage bootstrap/cache public

# Install PHP dependencies (skip diagnose to avoid build failure)
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Optional: install Filament only if not included in composer.json
# RUN composer require filament/filament:"^3.0" --no-interaction --no-scripts

# Expose port 80
EXPOSE 80

# Final setup and start Apache
CMD mkdir -p storage/app/public && \
    php artisan migrate --force && \
    php artisan db:seed --force && \
    php artisan storage:link && \
    chown -R www-data:www-data storage bootstrap/cache public/storage && \
    chmod -R 775 storage bootstrap/cache public/storage && \
    apache2-foreground
