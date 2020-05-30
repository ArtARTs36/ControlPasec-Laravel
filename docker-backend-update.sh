#!/usr/bin/env bash

# sh docker-backend-update.sh

git pull
echo "
composer dump-autoload
php artisan migrate
" | docker exec -i Laravel-php-fpm bash
