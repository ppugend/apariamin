FROM php:8.5-apache AS base

# PHP 확장 설치
RUN docker-php-ext-install pdo_mysql mysqli

# CVE-2026-115560 완화 (PHP 공식 권고, 다음 정기 릴리스에서 패치되면 제거)
RUN echo 'session.upload_progress.enabled=0' > /usr/local/etc/php/conf.d/security.ini

# Apache 설정
RUN a2enmod rewrite

# 개발용: Xdebug 포함
FROM base AS dev
RUN pecl install xdebug && docker-php-ext-enable xdebug
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# 운영용: Xdebug 미포함
FROM base AS prod
