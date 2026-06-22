#!/bin/sh

echo "PORT IS: $PORT"
echo "DB_HOST IS: $DB_HOST"

php artisan migrate --force || true
php artisan storage:link || true
php artisan config:cache || true

# Set Apache port to Railway PORT
echo "Listen $PORT" > /etc/apache2/ports.conf
echo "<VirtualHost *:$PORT>" > /etc/apache2/sites-available/000-default.conf
echo "    DocumentRoot /var/www/html/public" >> /etc/apache2/sites-available/000-default.conf
echo "    <Directory /var/www/html/public>" >> /etc/apache2/sites-available/000-default.conf
echo "        AllowOverride All" >> /etc/apache2/sites-available/000-default.conf
echo "        Require all granted" >> /etc/apache2/sites-available/000-default.conf
echo "    </Directory>" >> /etc/apache2/sites-available/000-default.conf
echo "</VirtualHost>" >> /etc/apache2/sites-available/000-default.conf

echo "Starting Apache on port $PORT..."
exec apache2-foreground