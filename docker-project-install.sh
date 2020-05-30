#!/usr/bin/env bash

# sh docker-project-install.sh

cp .env.docker.example .env

CURRENT_FOLDER=pwd|tr / "\n"|tail -1
CURRENT_FOLDER_LOWER_CASE=CURRENT_FOLDER| tr '[:upper:]' '[:lower:]'
DOCKER_NETWORK_NAME="${CURRENT_FOLDER_LOWER_CASE}_testing_get"

docker network create $DOCKER_NETWORK_NAME

docker-compose build

docker-compose up -d

echo "
cd ControlPasec-Laravel
composer install
php artisan key:generate
php artisan project-install
git clone https://github.com/ArtARTs36/control-pasec-vue/ frontend
cd frontend
yarn
yarn build
" | docker exec -i Laravel-php-fpm bash
