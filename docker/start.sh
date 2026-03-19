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

# Ensure writable paths and sqlite file
mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache database
touch database/database.sqlite
chown -R www-data:www-data storage bootstrap/cache database

# Generate key only if missing
if grep -q '^APP_KEY=$' .env || ! grep -q '^APP_KEY=base64:' .env; then
  php artisan key:generate --force || true
fi

php artisan config:clear || true
php artisan view:clear || true

# Never block startup on migration issues; app should still boot
php artisan migrate --force --no-interaction || true

exec apache2-foreground
