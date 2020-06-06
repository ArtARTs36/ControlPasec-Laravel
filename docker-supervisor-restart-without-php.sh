#!/usr/bin/env bash

# sh docker-supervisor-restart-without-php.sh

echo "
supervisorctl restart horizon:*
supervisorctl restart cron_listen:*
" | docker exec -i Laravel-php-fpm bash
