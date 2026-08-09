# Multi-stage Dockerfile for Zapateria POS

# --- Stage 1: Build & Vendor Dependencies ---
FROM composer:2 as vendor

WORKDIR /app

COPY composer.json composer.lock ./
COPY artisan ./artisan
COPY bootstrap ./bootstrap
COPY app ./app
COPY config ./config
COPY routes ./routes

RUN composer install --no-interaction --prefer-dist --optimize-autoloader --ignore-platform-reqs
# --- Stage 2: Node Build Assets ---
FROM node:20-alpine as frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY . .
COPY --from=vendor /app/vendor ./vendor
RUN npm run build

# --- Stage 3: Production Runtime (Alpine PHP-FPM) ---
FROM php:8.2-fpm-alpine

# Instalar extensiones necesarias de PHP (pdo_mysql, pdo_sqlite, zip, gd, etc.)
RUN apk add --no-cache \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    sqlite-dev \
    oniguruma-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite mbstring zip gd exif pcntl bcmath

WORKDIR /var/www/html

# Copiar aplicación y dependencias compiladas
COPY --chown=www-data:www-data . /var/www/html
COPY --from=vendor --chown=www-data:www-data /app/vendor /var/www/html/vendor
COPY --from=frontend --chown=www-data:www-data /app/public/build /var/www/html/public/build

# Ajustar permisos para usuario no-root www-data
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Cambiar a usuario sin privilegios (No-root)
USER www-data

EXPOSE 9000

CMD ["php-fpm"]
