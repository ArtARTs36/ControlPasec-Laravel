#!/usr/bin/env bash

# sh docker-composer-install.sh

echo "
cd ControlPasec-Laravel
composer install
" | docker exec -i Laravel-php-fpm bash
