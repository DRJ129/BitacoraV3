#!/bin/sh
set -e
if [ ! -f /var/www/vendor/autoload.php ]; then
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
exec "$@"
