FROM php:7.2-apache

RUN curl -Lo /usr/local/bin/composer http://getcomposer.org/composer.phar && \
    chmod +x /usr/local/bin/composer

RUN apt-get update && \
    apt-get install -y unzip libldap2-dev ca-certificates && \
    docker-php-ext-install ldap && \
    docker-php-ext-install pdo_mysql && \
    curl -Lo /usr/local/share/ca-certificates/tataranovich-cacert.crt https://www.tataranovich.com/public/tataranovich-cacert.crt && \
    update-ca-certificates && \
    a2enmod rewrite

COPY . /var/www/medikit

RUN chown -R www-data:www-data /var/www/medikit && \
    rmdir /var/www/html && \
    ln -s /var/www/medikit/public /var/www/html

WORKDIR /var/www/medikit

USER www-data

RUN composer install --no-dev

USER root