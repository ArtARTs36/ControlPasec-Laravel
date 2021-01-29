#!/usr/bin/env bash

# sh scripts/docker/backend-update.sh

git pull
echo "
cd ControlPasec-Laravel
composer install --no-dev --no-progress
composer dump-autoload --optimize
php artisan migrate --force
php artisan config:clear
php artisan cache:clear
php artisan route:clear
" | docker exec -i Laravel-php-fpm bash

sh scripts/docker/supervisor-update.sh
