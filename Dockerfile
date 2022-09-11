FROM php:7.4-apache

# Copy application files to contaier
COPY ./php/src/ /var/www/html/
# WORKDIR /var/www/html/
# CMD [ "php", "./index.php" ]
# CMD ["php-fpm"]

RUN apt-get update

# Install libzip
RUN apt-get install -y libzip-dev

# Install unzip
RUN apt-get install -y unzip

# Install PDO
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install mysqli

# Install zip by docker-php-ext tool
RUN docker-php-ext-install zip

# Enable mod rewrite
RUN a2enmod rewrite

# Install APCu
RUN pecl install apcu
RUN echo "extension=apcu.so" > /usr/local/etc/php/conf.d/apcu.ini

# Install git
RUN apt-get install -y git

# Install composer and make command global
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Set property permissions to files
RUN chown -R www-data:www-data /var/www/html