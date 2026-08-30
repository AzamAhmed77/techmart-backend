#!/bin/sh
set -e

# Create database file if missing
if [ ! -f /var/www/database/database.sqlite ]; then
    touch /var/www/database/database.sqlite
    chmod 777 /var/www/database/database.sqlite
fi

# Clear & Cache config
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Run migrations & seed data
php artisan migrate --force || true
php artisan db:seed --force || true

exec "$@"
