#!/bin/sh

echo "PORT IS: $PORT"
echo "DB_HOST IS: $DB_HOST"

php artisan config:clear
php artisan migrate --force || true
php artisan storage:link || true
php artisan config:cache

echo "Starting on port $PORT"
exec php artisan serve --host=0.0.0.0 --port=$PORT