#!/usr/bin/env bash

# sh scripts/docker/yarn-build.sh

echo "
cd ControlPasec-Laravel/frontend
yarn
yarn build
" | docker exec -i Laravel-php-fpm bash
