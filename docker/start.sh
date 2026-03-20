#!/usr/bin/env bash
set -e

cd /var/www/html

# Ensure .env exists in runtime image
if [ ! -f .env ] && [ -f .env.render ]; then
  cp .env.render .env
fi

# Force SQLite: override any Render dashboard env vars that may be set to pgsql
export DB_CONNECTION=sqlite
export DB_DATABASE=/var/www/html/database/database.sqlite
unset DATABASE_URL DB_HOST DB_PORT DB_USERNAME DB_PASSWORD DB_SSLMODE

# Also update .env file so config:cache picks up the correct values
sed -i 's/^DB_CONNECTION=.*/DB_CONNECTION=sqlite/' .env
sed -i 's|^DB_DATABASE=.*|DB_DATABASE=/var/www/html/database/database.sqlite|' .env

# Render exposes dynamic PORT
PORT_TO_USE="${PORT:-10000}"
sed -i "s/Listen 80/Listen ${PORT_TO_USE}/" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT_TO_USE}/" /etc/apache2/sites-available/*.conf

# Ensure writable paths
mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache

DB_DRIVER="sqlite"
mkdir -p database
touch database/database.sqlite
chown -R www-data:www-data database

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
