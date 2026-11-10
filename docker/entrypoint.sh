#!/bin/sh
set -e

cd /var/www/html

if [ ! -d vendor ]; then
  composer install --no-interaction --prefer-dist --ignore-platform-reqs
fi

mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
chmod -R 775 storage bootstrap/cache || true

if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:" ]; then
  php artisan key:generate --force || true
fi

# Wait for MySQL
i=0
until php -r "try { new PDO('mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD')); exit(0);} catch (Exception \$e) { exit(1);}" 2>/dev/null; do
  i=$((i+1))
  if [ "$i" -gt 60 ]; then
    echo "MySQL not ready after waiting"
    break
  fi
  echo "Waiting for MySQL... ($i)"
  sleep 2
done

php artisan migrate --force
php artisan db:seed --force
php artisan storage:link || true
php artisan filament:assets || true

exec "$@"
