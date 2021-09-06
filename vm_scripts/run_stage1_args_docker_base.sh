#!/bin/bash

set -o xtrace
#####################################################################
# Setup tmp dir
rm -rf /tmp/stage1.tmp
mkdir /tmp/stage1.tmp

#####################################################################
# Generate files to denote the system call names to numbers, system calls to arguments and 
# system calls to argument indices to be used for filtering
cd ~/stage1/interpreter-static-analysis
bash generate_args.sh
python3 generate_nopointer.py 0 > nopointersyscallargs.txt

#####################################################################
# Build and install PHP 7.1

cd ~/php-src
./configure --prefix=/opt/php-7.1 --with-pdo-pgsql --with-zlib-dir --with-freetype-dir=/usr/include/ --enable-mbstring --with-libxml-dir=/usr --enable-soap --enable-calendar --with-curl --with-mcrypt --with-zlib --with-pgsql --disable-rpath --enable-inline-optimization --with-bz2 --with-zlib --enable-sockets --enable-sysvsem --enable-sysvshm --enable-pcntl --enable-mbregex --enable-exif --enable-bcmath --with-mhash --enable-zip --with-pcre-regex --with-pdo-mysql --with-mysqli --with-mysql-sock=/var/run/mysqld/mysqld.sock --with-jpeg-dir=/usr --with-png-dir=/usr --enable-gd-native-ttf --with-openssl --with-fpm-user=www-data --with-fpm-group=www-data --with-libdir=/usr/lib/x86_64-linux-gnu --enable-ftp --with-kerberos --with-gettext --with-xmlrpc --with-xsl --enable-opcache --enable-fpm --enable-debug --with-gd --with-zlib --with-jpeg-dir=/usr/lib

make clean
make -j`nproc`
make install

#####################################################################
# Build and install [TE]/Tracing extension stage 1 component
cd ~/stage1/interpreter-tracing/TE_xdebug/
/opt/php-7.1/bin/phpize
./configure --with-php-config=/opt/php-7.1/bin/php-config
make clean
make -j`nproc`
make install

#####################################################################
# Build modified strace [TR] stage 1 component
cd ~/stage1/interpreter-tracing/TR_strace/
./configure --enable-mpers=check
make clean
make -j`nproc`

#####################################################################
# Run the PHP test-suite with the tracing extension(TE) enabled, while tracing
# with TR. Output the trace files to /tmp/traces (these will take up multiple
# gigabytes)

cd ~/php-src/

export MYSQL_TEST_USER=test 
export MYSQL_TEST_PASS=test 
export MYSQL_TEST_PASSWD=test 
export MYSQL_TEST_DB=test 
export PDO_MYSQL_TEST_DSN="mysql:dbname=test;host=localhost;port=3306" 
export PDO_MYSQL_TEST_USER=test 
export PDO_MYSQL_TEST_PASS=test 
export PDO_MYSQL_TEST_DB=test
export TEST_PHP_EXECUTABLE=/opt/php-7.1/bin/php

mkdir /tmp/stage1.tmp/traces

~/stage1/interpreter-tracing/TR_strace/strace -X raw -o /tmp/stage1.tmp/traces/trace -ff  /opt/php-7.1/bin/php -d zend_extension=xdebug.so ./run-tests.php -q -d zend_extension=xdebug.so
