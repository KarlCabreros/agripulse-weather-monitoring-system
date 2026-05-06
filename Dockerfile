FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --prefer-dist \
    --no-autoloader \
    --no-scripts


FROM node:22-bookworm-slim AS frontend

WORKDIR /app

COPY package.json package-lock.json vite.config.js ./
COPY --from=vendor /app/vendor ./vendor
COPY resources ./resources
COPY public ./public

RUN npm ci --include=optional && npm run build


FROM php:8.4-apache

WORKDIR /var/www/html

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        libicu-dev \
        libonig-dev \
        libpq-dev \
        libzip-dev \
        unzip \
    && docker-php-ext-install \
        bcmath \
        intl \
        mbstring \
        opcache \
        pdo_mysql \
        pdo_pgsql \
        zip \
    && a2enmod rewrite headers \
    && sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}/../!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./
COPY --from=vendor /app/vendor ./vendor

COPY . .
COPY --from=frontend /app/public/build ./public/build
COPY docker/start.sh /usr/local/bin/start-container

RUN composer dump-autoload --optimize \
    && php artisan package:discover --ansi \
    && rm -f public/hot \
    && mkdir -p storage/app storage/framework/cache/data storage/framework/sessions storage/framework/testing storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod +x /usr/local/bin/start-container

EXPOSE 10000

CMD ["start-container"]
