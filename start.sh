#!/bin/bash

echo "PORT IS: $PORT"
echo "DB_HOST IS: $DB_HOST"
echo "APP_KEY IS: $APP_KEY"

echo "Running migrations..."
php artisan migrate --force || echo "Migration failed but continuing..."

echo "Linking storage..."
php artisan storage:link || echo "Storage link failed but continuing..."

echo "Clearing config..."
php artisan config:clear || echo "Config clear failed but continuing..."

echo "Caching config..."
php artisan config:cache || echo "Config cache failed but continuing..."

echo "Starting server on port ${PORT:-8000}..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}