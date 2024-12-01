# Dockerfile for PHP-FPM with Composer and SQLite
FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /var/www/html

# Copy application files (adjust according to your project structure)
COPY ./src /var/www/html

# Permissions
RUN chown -R www-data:www-data /var/www/html

# Expose the port
EXPOSE 9000

CMD ["php-fpm"]
