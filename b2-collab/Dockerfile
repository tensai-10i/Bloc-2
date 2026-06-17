###############################################################################
# Stage 1 — base: PHP 8.2-FPM Alpine + extensions + Composer
###############################################################################
FROM php:8.4-fpm-alpine AS base

RUN apk add --no-cache \
        bash \
        curl \
        rsync \
        libzip-dev \
        libxml2-dev \
        oniguruma-dev \
        icu-dev \
        zip \
        unzip \
        git \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        ctype \
        fileinfo \
        xml \
        bcmath \
        zip \
        pcntl \
        intl \
    && rm -rf /var/cache/apk/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

###############################################################################
# Stage 2 — builder: install all deps + build Vite assets
###############################################################################
FROM base AS builder

RUN apk add --no-cache nodejs npm

COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-interaction --prefer-dist

COPY package.json package-lock.json ./
RUN npm ci --prefer-offline

COPY . .

RUN composer run-script post-autoload-dump

RUN npm run build

###############################################################################
# Stage 3 — production: lean image, no dev deps, permissions set
###############################################################################
FROM base AS production

COPY --from=builder /var/www/html /var/www/html

RUN composer install \
        --no-dev \
        --no-interaction \
        --prefer-dist \
        --optimize-autoloader \
    && rm -rf /root/.composer

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

COPY docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/zzz-custom.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 9000
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]

###############################################################################
# Stage 4 — development: base + Node.js, vendor from builder (code en volume)
###############################################################################
FROM base AS development

RUN apk add --no-cache nodejs npm

COPY --from=builder /var/www/html/vendor /var/www/html/vendor
COPY --from=builder /var/www/html/node_modules /var/www/html/node_modules

RUN mkdir -p \
        /var/www/html/storage/app/public \
        /var/www/html/storage/framework/cache/data \
        /var/www/html/storage/framework/sessions \
        /var/www/html/storage/framework/views \
        /var/www/html/storage/logs \
        /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

COPY docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/zzz-custom.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 9000
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]
