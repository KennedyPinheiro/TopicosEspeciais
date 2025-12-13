set -e

echo "1/6 - Building images (no cache)..."
docker compose build --no-cache

echo "2/6 - Starting containers..."
docker compose up -d

echo "3/6 - Waiting for DB to initialize (10s)..."
sleep 10

echo "4/6 - Ensuring composer and vendor if needed (inside backend container)..."
docker exec -it ivendas-backend bash -lc "\
  if [ -f composer.json ]; then \
    if command -v composer >/dev/null 2>&1; then \
      composer install --no-interaction || true; \
    else \
      echo 'Composer not found inside container, skipping composer install (install on host or update Dockerfile)'; \
    fi \
  fi"

echo "5/6 - Ensure .env exists (copy from example) and generate APP_KEY"
docker exec -it ivendas-backend bash -lc "\
  cd /var/www/html; \
  if [ ! -f .env ] && [ -f .env.example ]; then cp .env.example .env; fi; \
  php artisan key:generate || true; \
  php artisan migrate --force || true"

echo "6/6 - Fix permissions"
docker exec -it ivendas-backend bash -lc "chown -R www-data:www-data /var/www/html; chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache || true"
    
echo "Done. Frontend: http://localhost:5173  Backend: http://localhost:8080"
