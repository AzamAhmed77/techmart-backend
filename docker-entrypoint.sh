#!/bin/sh
set -e

# Restore migrations/seeders if empty in mounted volume
if [ ! -d /var/www/database/migrations ] && [ -d /var/www/database_backup/migrations ]; then
    cp -rn /var/www/database_backup/* /var/www/database/ || true
fi

# Create database file if missing
if [ ! -f /var/www/database/database.sqlite ]; then
    mkdir -p /var/www/database
    touch /var/www/database/database.sqlite
    chmod 777 /var/www/database/database.sqlite
fi

chmod -R 777 /var/www/database || true

# Run migrations & seed data
php artisan migrate --force || true
php artisan db:seed --force || true

# Clear & Cache config
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

exec "$@"
