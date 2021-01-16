#!/usr/bin/env bash

# sh scripts/docker/check-versions.sh

echo "
php -v
echo ""
composer --version
echo ""
echo \"Node version:\"
node --version
echo ""
echo \"Npm version:\"
npm --v
" | docker exec -i Laravel-php-fpm bash
