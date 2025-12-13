#!/bin/bash


chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

if [ ! -f .env ]; then
    cp .env.example .env
fi

if ! grep -q "APP_KEY=base64" .env; then
    php artisan key:generate
fi

exec apache2-foreground
