#!/bin/bash

cp -fa /var/www/public /sockets/

sed 's|DISPLAY_ERRORS|'$DISPLAY_ERRORS'|g;s|SOCKET|'$SOCKET'|g' /usr/local/etc/php-fpm.conf > /etc/php-fpm.conf

/usr/local/sbin/php-fpm --nodaemonize -c /var/www/docker/services/php-fpm/php-ini-overrides.ini -y /etc/php-fpm.conf
