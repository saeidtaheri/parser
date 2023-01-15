FROM php:8-fpm

RUN apt-get update

RUN apt-get install -y \
    vim \
    git \
    zip \
    nano \
    curl \
    wget \
    tree \
    tmux \
    screen \
    sudo \
    unzip \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev\
    libxslt-dev \
    freetds-dev \
    libonig-dev\
    libcurl4-openssl-dev \
    libssl-dev \
    libzip-dev \
    zip \
    g++

RUN docker-php-ext-install \
    gd \
    bz2 \
    intl \
    phar \
    iconv \
    ctype \
    bcmath \
    mysqli \
    pdo \
    pdo_mysql \
    sockets \
    calendar \
    zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#RUN acurl -sL https://deb.nodesource.com/setup_13.x | sudo -E bash -
#RUN sudo apt-get install -y \
#    nodejs \
#    npm \
#    build-essential

ARG uid
RUN useradd -G www-data,root -u $uid -d /home/parser parser
RUN mkdir -p /home/parser/.composer && \
    chown -R parser:parser /home/parser

WORKDIR /srv/www

