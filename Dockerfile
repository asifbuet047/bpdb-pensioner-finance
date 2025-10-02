# Stage 1: Composer build
FROM composer:2 AS build

WORKDIR /app

# Copy dependency files first
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install --no-dev --no-scripts --prefer-dist --optimize-autoloader

# Stage 2: PHP runtime
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip git unzip curl libonig-dev libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

WORKDIR /var/www

# Copy vendor folder from build stage
COPY --from=build /app/vendor ./vendor

# Copy rest of the project
COPY . .

# Laravel setup
RUN php artisan key:generate
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache || true

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
