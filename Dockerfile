FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip \
    libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN php artisan config:clear || true
RUN php artisan view:clear || true

EXPOSE 8000

CMD php artisan migrate --force; php artisan storage:link; php artisan serve --host=0.0.0.0 --port=$PORT