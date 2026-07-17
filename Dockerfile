FROM php:8.2-apache

# Cache bust: force rebuild 2026-03-20
# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libsqlite3-dev libpq-dev \
    && docker-php-ext-install pdo pdo_sqlite pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set DocumentRoot to Laravel's public folder
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

# Avoid Apache startup warning and ensure a stable vhost baseline
RUN printf 'ServerName localhost\n' > /etc/apache2/conf-available/servername.conf \
    && a2enconf servername

# Allow .htaccess overrides
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

WORKDIR /var/www/html

# Copy application source
COPY . .

# Use Render environment template as default .env
RUN cp .env.render .env

# Install Node.js for Vite build
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts \
    && php artisan storage:link || true

# Build frontend assets with Vite
RUN npm ci --no-audit && npm run build

# Prepare writable directories
RUN mkdir -p storage/framework/{cache,sessions,views} database \
    && chown -R www-data:www-data storage bootstrap/cache database

# Runtime bootstrap script for Render
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

EXPOSE 10000

CMD ["/usr/local/bin/start.sh"]
