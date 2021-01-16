#!/usr/bin/env bash

# sh scripts/docker/composer-install.sh

echo "
cd ControlPasec-Laravel
composer install
" | docker exec -i Laravel-php-fpm bash
