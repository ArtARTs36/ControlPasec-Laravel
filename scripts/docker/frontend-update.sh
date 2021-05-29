#!/usr/bin/env bash

# sh scripts/docker/frontend-update.sh

echo "
cd ControlPasec-Laravel/frontend
git pull
yarn
yarn build
rsync -av --delete dist build
" | docker exec -i Laravel-php-fpm bash
