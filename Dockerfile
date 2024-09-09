# Use PHP 8.3 as the base image
FROM php:8.3.11 as php

# Define build arguments for UID and username
ARG uid=1000
ARG user=myuser

# Update and install necessary packages
RUN apt-get update -y \
    && apt-get install -y unzip libpq-dev libcurl4-gnutls-dev wget git curl \
    && docker-php-ext-install pdo pdo_mysql bcmath \
    && pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

# Install Composer
RUN wget https://getcomposer.org/installer -O composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

# Install Node.js and npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Create a new user with the specified UID
RUN useradd -u ${uid} -m -s /bin/bash ${user} \
    && echo "${user} ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers

# Set working directory
WORKDIR /var/www

# Copy application files
COPY . .

# Ensure the log file exists and set the correct permissions
RUN mkdir -p /var/www/storage/logs \
    && touch /var/www/storage/logs/laravel.log \
    && chown myuser:myuser /var/www/storage/logs/laravel.log \
    && chmod 664 /var/www/storage/logs/laravel.log

# Change ownership of the working directory
RUN chown -R ${user}:${user} /var/www

# Switch to the new user
USER ${user}

# Set environment variable
ENV PORT=8000

# Command to run the PHP application
CMD ["php", "artisan", "serve", "--port=8000", "--host=0.0.0.0", "--env=.env"]
