FROM php:8.1.9-apache

RUN a2enmod rewrite
RUN docker-php-ext-install pdo pdo_mysql

ADD . /var/www/html

EXPOSE 80
