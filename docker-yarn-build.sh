#!/usr/bin/env bash

# sh docker-yarn-build.sh

echo "
cd frontend
yarn
yarn build
" | docker exec -i Laravel-php-fpm bash
