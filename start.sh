#!/bin/bash
set -e

echo "Running migrations..."
php artisan migrate --force

echo "Linking storage..."
php artisan storage:link || true

echo "Caching config..."
php artisan config:cache

echo "Starting server..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}