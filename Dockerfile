FROM php:8.2-apache

RUN rm -f /etc/apache2/mods-enabled/mpm_*.load \
    && rm -f /etc/apache2/mods-enabled/mpm_*.conf \
    && a2enmod mpm_prefork \
    && docker-php-ext-install mysqli

COPY . /var/www/html/

EXPOSE 80