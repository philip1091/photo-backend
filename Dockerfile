FROM php:8.1-fpm-alpine

WORKDIR /var/www/html

COPY . .

RUN chmod -R 777 storage bootstrap/cache

RUN apk add --no-cache libzip libpng libjpeg-turbo libwebp \
    && apk add --no-cache --virtual build-essentials \
    libzip-dev libpng-dev libwebp-dev libjpeg-turbo-dev freetype-dev \
    && docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install gd pdo pdo_mysql exif zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN addgroup -g 1000 laravel && adduser -G laravel -g laravel -s /bin/sh -D laravel

USER laravel

WORKDIR /usr/local/etc/php

COPY php_config/php .
