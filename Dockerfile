FROM php:8.2-cli

WORKDIR /app

# Install ekstensi yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev zip \
    && docker-php-ext-install pdo_mysql mbstring gd

# Copy project
COPY . .

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Laravel cache clear (biar gak nyangkut config lama)
RUN php artisan config:clear || true
RUN php artisan cache:clear || true

# Port dari Railway
EXPOSE 8080

# Start pakai PORT dari Railway
CMD php artisan serve --host=0.0.0.0 --port=$PORT