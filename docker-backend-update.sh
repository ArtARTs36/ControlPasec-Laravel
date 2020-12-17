#!/usr/bin/env bash

# sh docker-backend-update.sh

git pull
echo "
cd ControlPasec-Laravel
composer install --no-progress
composer dump-autoload --optimize
php artisan migrate --force
php artisan config:clear
php artisan cache:clear
php artisan route:clear
" | docker exec -i Laravel-php-fpm bash

sh docker-supervisor-update.sh
