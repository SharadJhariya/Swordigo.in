FROM php:8.2-apache

# Install system deps + git and build pdo_mysql
RUN apt-get update \
 && apt-get install -y --no-install-recommends \
      git \
      default-libmysqlclient-dev \
      build-essential \
 && docker-php-ext-install pdo_mysql \
 && a2enmod rewrite \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/*
