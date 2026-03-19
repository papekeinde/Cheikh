FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libsqlite3-dev \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_sqlite pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set DocumentRoot to Laravel's public folder
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Allow .htaccess overrides
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

WORKDIR /var/www/html

# Copy composer files and install PHP dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy package files and build assets
COPY package.json package-lock.json* ./
RUN npm install

# Copy the rest of the application
COPY . .

# Use production env
RUN cp .env.render .env

# Run composer scripts after full copy
RUN composer dump-autoload --optimize

# Build frontend assets
RUN npm run build

# Create SQLite database and set permissions
RUN touch database/database.sqlite \
    && chown -R www-data:www-data storage bootstrap/cache database

# Generate key, run migrations and seed
RUN php artisan key:generate --force \
    && php artisan config:clear \
    && php artisan migrate --force \
    && php artisan db:seed --force

EXPOSE 80

CMD ["apache2-foreground"]
