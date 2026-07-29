# #!/bin/sh

# echo "PORT IS: $PORT"
# echo "DB_HOST IS: $DB_HOST"
# echo "DB_PORT IS: $DB_PORT"
# echo "DB_DATABASE IS: $DB_DATABASE"
# echo "DB_USERNAME IS: $DB_USERNAME"

# # Clear all caches first
# php artisan config:clear
# php artisan cache:clear
# php artisan view:clear
# php artisan route:clear

# # Test DB connection first
# php artisan db:show 2>&1 || echo "DB connection failed"

# # Run migrations
# echo "Running migrations..."
# php artisan migrate --force 2>&1

# echo "Done migrations"
# php artisan storage:link || true

# echo "Starting on port $PORT"
# exec php artisan serve --host=0.0.0.0 --port=$PORT


#!/bin/sh
set -e

echo "Starting deployment..."

php artisan config:clear
php artisan migrate --force

php artisan storage:link || true

echo "Starting server on port $PORT..."
exec php artisan serve --host=0.0.0.0 --port=$PORT