FROM composer:lts as deps
WORKDIR /var/www/html
RUN apk add --no-cache icu-dev && docker-php-ext-install intl
COPY ./laravel-app /var/www/html
RUN composer install --no-dev --no-interaction

FROM php:8.2-apache as final
RUN apt-get update && apt-get install -y libicu-dev libmariadb-dev libzip-dev && \
    docker-php-ext-install intl pdo pdo_mysql zip && \
    rm -rf /var/lib/apt/lists/*
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY --from=deps /var/www/html /var/www/html
RUN chown -R www-data:www-data /var/www/html
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

USER root
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

EXPOSE 9000
EXPOSE 80
CMD ["apache2-foreground"]
