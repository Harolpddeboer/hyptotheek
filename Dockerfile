FROM composer:lts as deps
WORKDIR /var/www/html
RUN apk add --no-cache icu-dev && docker-php-ext-install intl
COPY ./laravel-app /var/www/html
RUN composer install --no-dev --no-interaction

FROM php:8.2-apache as final
RUN apt-get update && apt-get install -y libicu-dev libmariadb-dev && \
    docker-php-ext-install intl pdo pdo_mysql && \
    rm -rf /var/lib/apt/lists/*
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY --from=deps /var/www/html /var/www/html
RUN chown -R www-data:www-data /var/www/html
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
USER www-data
