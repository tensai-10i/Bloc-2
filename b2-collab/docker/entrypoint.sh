#!/bin/bash
set -e

wait_for_db() {
    echo "Waiting for MySQL at ${DB_HOST}:${DB_PORT:-3306}..."
    local retries=30
    until php -r "
        try {
            new PDO(
                'mysql:host=${DB_HOST};port=${DB_PORT:-3306};dbname=${DB_DATABASE}',
                '${DB_USERNAME}',
                '${DB_PASSWORD}'
            );
            exit(0);
        } catch (Exception \$e) {
            exit(1);
        }
    " 2>/dev/null; do
        retries=$((retries - 1))
        if [ "$retries" -le 0 ]; then
            echo "ERROR: MySQL not reachable after 30 attempts. Aborting."
            exit 1
        fi
        echo "  MySQL not ready, retrying in 2s... ($retries attempts left)"
        sleep 2
    done
    echo "MySQL is ready."
}

fix_permissions() {
    chown -R www-data:www-data \
        /var/www/html/storage \
        /var/www/html/bootstrap/cache \
        2>/dev/null || true
    chmod -R 775 \
        /var/www/html/storage \
        /var/www/html/bootstrap/cache \
        2>/dev/null || true
}

APP_ENV="${APP_ENV:-local}"

fix_permissions

case "$APP_ENV" in
    production)
        echo "==> Production startup"
        wait_for_db
        php artisan migrate --force --no-interaction
        php artisan config:cache
        php artisan route:cache
        php artisan view:cache
        php artisan event:cache
        rsync -a --delete /var/www/html/public/ /var/www/public/
        ;;
    staging)
        echo "==> Preprod/staging startup"
        wait_for_db
        php artisan migrate --force --no-interaction
        php artisan config:clear
        php artisan route:clear
        php artisan view:clear
        rsync -a --delete /var/www/html/public/ /var/www/public/
        ;;
    local|*)
        echo "==> Local development startup"
        wait_for_db
        php artisan migrate --no-interaction
        ;;
esac

echo "==> Starting: $@"
exec "$@"
