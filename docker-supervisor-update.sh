#!/usr/bin/env bash

# sh docker-supervisor-update.sh

echo "
\cp -R ControlPasec-Laravel/docker-files/php-fpm/supervisor-apps/* /etc/supervisor/conf.d
" | docker exec -i Laravel-php-fpm bash
