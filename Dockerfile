FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev zip \
    && docker-php-ext-install pdo_mysql mbstring gd

COPY . .

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

RUN chmod -R 777 storage bootstrap/cache

# IMPORTANT: paksa fallback port kalau $PORT kosong
CMD ["sh", "-c", "PORT=${PORT:-8080} php -S 0.0.0.0:$PORT -t public"]