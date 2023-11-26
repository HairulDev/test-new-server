# Define base image
ARG PHP_VERSION
ARG OS_VERSION
FROM php:$PHP_VERSION-fpm-alpine$OS_VERSION

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apk update && apk add \
    autoconf \
    g++ \
    make \
    unixodbc \ 
    unixodbc-dev \
    gnupg \
    supervisor 

# Install SQL Server PDO extension
RUN pecl install sqlsrv pdo_sqlsrv \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv

# Install ODBC driver for SQL Server
RUN curl -O https://download.microsoft.com/download/1/f/f/1fffb537-26ab-4947-a46a-7a45c27f6f77/msodbcsql18_18.2.2.1-1_amd64.apk \
    && curl -O https://download.microsoft.com/download/1/f/f/1fffb537-26ab-4947-a46a-7a45c27f6f77/mssql-tools18_18.2.1.1-1_amd64.apk \
    && curl https://packages.microsoft.com/keys/microsoft.asc | gpg --import - \
    && apk add --allow-untrusted msodbcsql18_18.2.2.1-1_amd64.apk mssql-tools18_18.2.1.1-1_amd64.apk

# Copy php ini
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN sed -i -e 's/memory_limit = 128M/memory_limit = 2048M/g' "$PHP_INI_DIR/php.ini"

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy application files
COPY . /var/www/

# Install application dependencies
RUN composer install --optimize-autoloader --no-dev

# Expose port
EXPOSE 9000

# Copy supervisor config
COPY docker/prod/supervisor/ /etc/

# Run supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]