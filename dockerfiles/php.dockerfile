FROM php:8.3-fpm-alpine

WORKDIR /var/www/html

COPY ./src .

# Install necessary build dependencies
RUN apk add --no-cache \
    autoconf \
    g++ \
    libcurl \
    curl-dev \
    pkgconfig \
    openssl-dev \
    make
    

# Install the PECL extension
RUN pecl install mongodb

# RUN pecl config-set php_ini /etc/php.ini

# Enable the extension in PHP configuration
RUN docker-php-ext-enable mongodb.so

RUN docker-php-ext-install pdo pdo_mysql

RUN addgroup -g 1000 laravel && adduser -G laravel -g laravel -s /bin/sh -D laravel

USER laravel