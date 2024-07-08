FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN docker-php-ext-install pdo pdo_mysql zip mysqli

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ARG uid
RUN useradd -G www-data,root -u $uid -d /home/parser parser
RUN mkdir -p /home/parser/.composer && \
    chown -R parser:parser /home/parser

WORKDIR /srv/www

