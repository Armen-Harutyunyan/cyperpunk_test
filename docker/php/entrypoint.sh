#!/usr/bin/env bash
set -euo pipefail

cd /var/www/html

export COMPOSER_CACHE_DIR="${COMPOSER_CACHE_DIR:-/tmp/composer-cache}"

if [ ! -f vendor/autoload.php ] || [ ! -f web/wp/wp-settings.php ]; then
  composer install --no-interaction --prefer-dist
fi

mkdir -p web/app/uploads
chown -R www-data:www-data web/app/uploads || true

exec "$@"
