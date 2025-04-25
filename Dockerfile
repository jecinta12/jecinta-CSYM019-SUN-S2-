FROM php:8.1-apache

RUN docker-php-ext-install pdo pdo_mysql

COPY ./src /var/www/html/
COPY ./nginx.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80
