#!/usr/bin/env bash

# sh docker-check-versions-packages.sh

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
