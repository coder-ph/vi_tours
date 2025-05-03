# Use official PHP image with Apache
FROM php:8.1-apache

# Copy your code to the Apache server root
COPY backend/ /var/www/html/

# Install any PHP extensions you need
RUN docker-php-ext-install mysqli

# Give Apache access rights (optional based on your code)
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80
