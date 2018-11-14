FROM php:7.2.12-fpm

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
RUN ln -snf /usr/share/zoneinfo/$TIMEZONE /etc/localtime && echo $TIMEZONE > /etc/timezone