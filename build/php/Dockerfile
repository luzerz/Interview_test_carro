FROM php:7.2-fpm

RUN apt-get update && apt-get install -y \
    mariadb-client libmagickwand-dev --no-install-recommends curl nano \
    && docker-php-ext-install \
    zip xml gd \
    pdo_mysql

# composer
RUN apt-get install wget -y
RUN wget https://getcomposer.org/installer -P /tmp
RUN mv /tmp/installer /tmp/composer-setup.php
RUN php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer

RUN mkdir -p /www

COPY . /www
WORKDIR /www
#RUN composer install
#RUN npm install
RUN chmod -R 777 storage
EXPOSE 9000