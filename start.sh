#!/bin/sh

echo "PORT IS: $PORT"
echo "DB_HOST IS: $DB_HOST"

php artisan config:clear
php artisan cache:clear

echo "Running migrations..."
php artisan migrate:fresh --force --verbose

php artisan db:seed --force || true
php artisan storage:link || true
php artisan config:cache

echo "Starting on port $PORT"
exec php artisan serve --host=0.0.0.0 --port=$PORT