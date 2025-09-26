FROM php:8.2-apache

# Prevent interactive prompts during installation
ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=America/Sao_Paulo

# Install dependencies
RUN apt-get update && apt-get install -y \
    mariadb-server \
    git unzip libpng-dev libonig-dev libxml2-dev zip curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && a2enmod rewrite

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Install Compose
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy custom Apache configuration
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Copy application code
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts
    
# Create required Laravel directories and set permissions
RUN mkdir -p \
      storage/framework/cache/data \
      storage/framework/sessions \
      storage/framework/views \
      storage/logs \
      bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# MySQL environment variables
ENV MYSQL_DATABASE=laravel
ENV MYSQL_ROOT_PASSWORD=root
ENV MYSQL_USER=laravel
ENV MYSQL_PASSWORD=secret

# Copy the startup script
COPY start.sh /start.sh
RUN chmod +x /start.sh

# Startup script: start MySQL, run migrations, insert setting row, then start Apache
CMD ["/start.sh"]
