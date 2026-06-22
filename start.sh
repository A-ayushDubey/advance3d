#!/bin/sh

echo "PORT IS: $PORT"
echo "DB_HOST IS: $DB_HOST"

php artisan config:clear
php artisan migrate --force
php artisan config:cache

echo "Starting on port $PORT"
exec php -S 0.0.0.0:$PORT -t public