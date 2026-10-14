# ==========================================
# Stage 1: Node Builder (Vite Asset Bundler)
# ==========================================
FROM node:22-alpine AS node_builder
WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY resources/ ./resources/
COPY public/ ./public/
COPY vite.config.js ./
RUN npm run build

# ==========================================
# Stage 2: Composer Dependency Builder
# ==========================================
FROM composer:2.8 AS composer_builder
WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts \
    --ignore-platform-reqs

# ==========================================
# Stage 3: Final Production PHP-FPM Image
# ==========================================
FROM php:8.4-fpm-alpine

WORKDIR /var/www

# Install runtime system packages and build dependencies
RUN apk add --no-cache \
    bash \
    curl \
    git \
    unzip \
    libpng \
    libpng-dev \
    libjpeg-turbo \
    libjpeg-turbo-dev \
    freetype \
    freetype-dev \
    libzip \
    libzip-dev \
    libxml2 \
    libxml2-dev \
    oniguruma-dev \
    icu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        zip \
        gd \
        bcmath \
        xml \
        opcache \
        intl \
        pcntl \
    && apk del --no-cache \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        libzip-dev \
        libxml2-dev \
        oniguruma-dev \
        icu-dev

# Copy Composer binary from official image
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

# Copy application source code
COPY . /var/www

# Copy built vendor and assets from builder stages
COPY --from=composer_builder /app/vendor /var/www/vendor
COPY --from=node_builder /app/public/build /var/www/public/build

# Copy PHP custom configuration
COPY docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini

# Copy entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Fix ownership and storage permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]
