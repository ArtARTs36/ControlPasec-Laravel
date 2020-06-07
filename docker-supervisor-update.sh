#!/usr/bin/env bash

# sh docker-supervisor-update.sh

echo "
\cp -R -f /ControlPasec-Laravel/docker-files/php-fpm/supervisor-apps/* /etc/supervisor/conf.d
supervisorctl update
supervisorctl restart horizon:*
supervisorctl restart cron_listen:*
" | docker exec -i Laravel-php-fpm bash
