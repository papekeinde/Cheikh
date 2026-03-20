#!/usr/bin/env bash
set -e

cd /var/www/html

# Ensure .env exists in runtime image
if [ ! -f .env ] && [ -f .env.render ]; then
  cp .env.render .env
fi

# Render exposes dynamic PORT
PORT_TO_USE="${PORT:-10000}"
sed -i "s/Listen 80/Listen ${PORT_TO_USE}/" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT_TO_USE}/" /etc/apache2/sites-available/*.conf

# Ensure writable paths
mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache

# Create sqlite database file only when sqlite is selected
DB_DRIVER="$(grep -E '^DB_CONNECTION=' .env | cut -d '=' -f2 | tr -d '[:space:]')"
if [ "${DB_DRIVER}" = "sqlite" ]; then
  mkdir -p database
  touch database/database.sqlite
  chown -R www-data:www-data database
fi

chown -R www-data:www-data storage bootstrap/cache

# Generate key only if missing
if grep -q '^APP_KEY=$' .env || ! grep -q '^APP_KEY=base64:' .env; then
  php artisan key:generate --force || true
fi

php artisan config:clear || true
php artisan view:clear || true
php artisan route:clear || true
php artisan cache:clear || true
php artisan package:discover --ansi || true

# Never block startup on migration issues; app should still boot
if [ "${DB_DRIVER}" = "sqlite" ]; then
  # SQLite: fresh migrate + seed on each deploy (Render filesystem is ephemeral)
  php artisan migrate:fresh --seed --force --no-interaction || true
else
  php artisan migrate --force --no-interaction || true
fi

exec apache2-foreground
