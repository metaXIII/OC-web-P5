FROM php:7.3.0-apache

RUN a2enmod rewrite
RUN docker-php-ext-install pdo pdo_mysql

EXPOSE 80