FROM php:7.4-apache

# Install required system packages
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libicu-dev \
    libxml2-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    nano \
    vim

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql pgsql intl gd zip

# Enable Apache rewrite
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
