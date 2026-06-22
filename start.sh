#!/bin/bash
set -e

echo "PORT IS: $PORT"
echo "DB_HOST IS: $DB_HOST"
echo "APP_KEY IS: $APP_KEY"

php artisan migrate --force
php artisan storage:link || true
php artisan config:clear
php artisan cache:clear

exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}