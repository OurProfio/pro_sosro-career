#!/bin/sh
set -e

# Ensure required directories exist
mkdir -p /var/www/storage/framework/cache/data
mkdir -p /var/www/storage/framework/sessions
mkdir -p /var/www/storage/framework/views
mkdir -p /var/www/storage/logs
mkdir -p /var/www/storage/app/public
mkdir -p /var/www/bootstrap/cache

# Set permissions
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Create storage symlink if not exists
if [ ! -L /var/www/public/storage ]; then
    php artisan storage:link --force || true
fi

# If the command is php-fpm, cache config if .env is present
if [ "$1" = "php-fpm" ]; then
    if [ -f /var/www/.env ]; then
        echo "Optimizing Laravel configuration and routes..."
        php artisan config:cache || true
        php artisan route:cache || true
        php artisan view:cache || true
    fi
fi

exec "$@"
