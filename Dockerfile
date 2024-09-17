# Use the official PHP image with Apache
FROM php:8.2.12-apache

# Copy your application code to the container
COPY . /var/www/html/

# Set the working directory
WORKDIR /var/www/html

# Install any required PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Expose port 80 to the outside world
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
