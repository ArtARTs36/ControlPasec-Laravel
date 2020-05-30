#!/usr/bin/env bash

# sh docker-backend-update.sh

git pull
echo "
composer dump-autoload --optimize
php artisan migrate --force
" | docker exec -i Laravel-php-fpm bash
