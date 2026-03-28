FROM php:8.2-apache

# Installation des extensions PHP et activation du module rewrite Apache
RUN docker-php-ext-install mysqli pdo pdo_mysql && a2enmod rewrite

# Configuration d'Apache pour autoriser les .htaccess (AllowOverride All)
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

COPY www/ /var/www/html/

RUN chown -R www-data:www-data /var/www/html

