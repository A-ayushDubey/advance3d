#!/bin/bash
php artisan migrate --force
php artisan storage:link || true
php artisan config:cache
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}