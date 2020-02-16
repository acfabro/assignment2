FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
        libicu-dev \
    && docker-php-ext-install \
        intl \
        pdo_mysql \
    && docker-php-ext-enable \
        pdo_mysql \
        intl \
    && pecl install \
        redis \
    && cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini \
    && echo "extension=redis.so" >> /usr/local/etc/php/php.ini
