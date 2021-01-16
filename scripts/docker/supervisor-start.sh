#!/usr/bin/env bash

# sh scripts/docker/docker-supervisor-start.sh

echo "
/usr/bin/supervisord -c /etc/supervisor/supervisord.conf
" | docker exec -i Laravel-php-fpm bash
