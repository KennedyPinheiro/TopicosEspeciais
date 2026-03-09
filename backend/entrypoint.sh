#!/bin/sh

echo "Inicializando backend Laravel..."

mkdir -p storage/framework/cache \
         storage/framework/sessions \
         storage/framework/views \
         storage/logs

chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

if [ ! -f .env ]; then
    cp .env.example .env
fi

php artisan key:generate --force || true

if [ ! -d vendor ]; then
    composer install --no-interaction --prefer-dist || true
fi

echo "Subindo Apache..."
exec apache2-foreground
