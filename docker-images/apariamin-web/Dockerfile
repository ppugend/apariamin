FROM php:8.2-apache

# Xdebug 및 PHP 확장 설치
RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN apt-get update && apt-get install -y libzip-dev \
    && docker-php-ext-install pdo_mysql mysqli

# Apache 설정
RUN a2enmod rewrite

# Xdebug 설정 복사
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
