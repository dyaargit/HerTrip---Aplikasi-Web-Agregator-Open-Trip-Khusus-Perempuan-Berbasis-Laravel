
# ==========================================
# STAGE 1: Build frontend with Node.js 22
# ==========================================
FROM node:22-alpine AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build


# ==========================================
# STAGE 2: Laravel + PHP + Apache
# ==========================================
FROM php:8.3-apache

# Install PHP dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    ca-certificates \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl \
    opcache \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy Laravel project
COPY . .

# Copy built frontend assets
COPY --from=frontend /app/public/build ./public/build

# Copy TiDB SSL certificate
COPY docker/tidb-ca.pem /etc/ssl/certs/tidb-ca.pem

# Configure Apache document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf \
    && printf '<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>\n' \
    > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel

# Configure Apache port for Render
RUN sed -ri 's/Listen 80/Listen 10000/' /etc/apache2/ports.conf \
    && sed -ri 's/<VirtualHost \*:80>/<VirtualHost *:10000>/' \
    /etc/apache2/sites-available/000-default.conf

# Create Laravel writable directories
RUN mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && composer install \
        --no-dev \
        --no-interaction \
        --prefer-dist \
        --optimize-autoloader \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Production environment
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV MYSQL_ATTR_SSL_CA=/etc/ssl/certs/tidb-ca.pem
ENV PORT=10000

EXPOSE 10000

CMD ["apache2-foreground"]