FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql && a2enmod rewrite

COPY www/ /var/www/html/

RUN chown -R www-data:www-data /var/www/html
