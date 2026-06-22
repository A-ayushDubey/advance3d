#!/bin/bash

echo "=== Starting Advance3D ==="

echo "=== Clearing config ==="
php artisan config:clear

echo "=== Caching config ==="
php artisan config:cache

echo "=== Running migrations ==="
php artisan migrate --force

echo "=== Linking storage ==="
php artisan storage:link || true

echo "=== Starting server on port $PORT ==="
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}