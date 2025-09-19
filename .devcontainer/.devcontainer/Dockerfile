FROM php:8.2-apache

# Install system dependencies and PHP extensions
RUN apt-get update \
 && apt-get install -y --no-install-recommends \
      git \
      default-libmysqlclient-dev \
      build-essential \
 && docker-php-ext-install pdo_mysql \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/*

# Enable Apache modules (optional but common)
RUN a2enmod rewrite
