FROM php:8.4-apache

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip mbstring exif pcntl bcmath gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN rm -f /etc/apache2/mods-enabled/mpm_event.load \
    /etc/apache2/mods-enabled/mpm_event.conf \
    /etc/apache2/mods-enabled/mpm_worker.load \
    /etc/apache2/mods-enabled/mpm_worker.conf \
    && a2enmod mpm_prefork rewrite

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN npm install
RUN npm run build

RUN mkdir -p storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80

CMD php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear && \
    php artisan migrate --force && \
    apache2-foreground
