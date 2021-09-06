#!/bin/bash

# Fix conf files for php-fpm
cp /opt/php-7.1/etc/php-fpm.d/www.conf.default /opt/php-7.1/etc/php-fpm.d/www.conf
cp /opt/php-7.1/etc/php-fpm.conf.default /opt/php-7.1/etc/php-fpm.conf

# Create php.ini [php should first be installed in stage 1]
echo "memory_limit=-1" > /opt/php-7.1/lib/php.ini
echo "seccomp.app_base=\"/var/www/html\"" >> /opt/php-7.1/lib/php.ini
echo "seccomp.profile_path=\"/var/www/filter\"" >> /opt/php-7.1/lib/php.ini

/etc/init.d/mysql start #or alternatively for newer debian: service mariadb start
/etc/init.d/nginx start

mysql -u root Joomla < /root/Joomla.sql
mysql -u root drupal < /root/drupal.sql

update-alternatives --install /usr/bin/php php /opt/php-7.1/bin/php 100

Xvfb -ac :99 -screen 0 1280x1024x16 &
export DISPLAY=:99
