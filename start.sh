#!/bin/bash

echo "=== Starting Advance3D ==="

echo "=== Clearing config ==="
php artisan config:clear

echo "=== Running migrations ==="
php artisan migrate --force

echo "=== Linking storage ==="
php artisan storage:link || true

echo "=== Caching config ==="
php artisan config:cache

echo "=== Starting server on port $PORT ==="
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}