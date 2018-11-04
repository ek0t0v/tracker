FROM php:7.2.10-fpm

ENV TIMEZONE=UTC

COPY php.ini /usr/local/etc/php

RUN apt-get update && \
    apt-get install -y \
    libpq-dev \
    zlib1g-dev \
    git \
    zip \
    unzip \
    cron
RUN docker-php-ext-install \
    bcmath \
    opcache \
    pdo \
    pdo_pgsql \
    zip
RUN curl --silent --show-error https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    chmod +x /usr/local/bin/composer && \
    usermod www-data -u 1000 && \
    chown -R www-data:www-data /var/www
RUN ln -snf /usr/share/zoneinfo/$TIMEZONE /etc/localtime && echo $TIMEZONE > /etc/timezone