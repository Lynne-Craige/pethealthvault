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

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Clean cached bootstrap
RUN rm -rf bootstrap/cache/*.php

# Use .env.example as default
COPY --chown=www-data:www-data .env.example .env

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --verbose

# Set correct permissions
RUN chown -R www-data:www-data storage bootstrap/cache public \
    && chmod -R 775 storage bootstrap/cache public

# Expose port
EXPOSE 80

# Start Apache only; migrations run from Render's startCommand
CMD ["apache2-foreground"]
