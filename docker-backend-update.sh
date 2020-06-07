#!/usr/bin/env bash

# sh docker-backend-update.sh

git pull
echo "
cd ControlPasec-Laravel
composer install --no-dev --no-progress
composer dump-autoload --optimize
php artisan migrate --force
php artisan config:clear
php artisan cache:clear
" | docker exec -i Laravel-php-fpm bash

sh docker-supervisor-update.sh
