FROM composer:2.0 as build
COPY . /app/
RUN composer install --prefer-dist --no-dev --optimize-autoloader --no-interaction

FROM php:8.0-apache-buster as production

ENV APP_ENV=production
ENV APP_DEBUG=false

RUN docker-php-ext-install pdo pdo_mysql
COPY docker/apache/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY docker/apache/xdebug.ini  /usr/local/etc/php/conf.d/xdebug.ini

COPY --from=build /app /var/www/html
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

#COPY .env.prod /var/www/html/.env

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN php artisan config:cache && \
    php artisan route:cache && \
    chmod 777 -R /var/www/html/storage/ && \
    chown -R www-data:www-data /var/www/ && \
    a2enmod rewrite