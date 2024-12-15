FROM php:8.0-fpm

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y \
       git \
       unzip \
       libzip-dev \
    && docker-php-ext-install zip
    
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Symfony CLI
RUN wget https://get.symfony.com/cli/installer -O - | bash

EXPOSE 8000
