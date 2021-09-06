FROM debian:buster

RUN apt-get update && apt-get install --no-install-recommends -y apt-utils build-essential libxml2-dev libssl-dev zlib1g-dev libbz2-dev libmcrypt-dev mariadb-server mariadb-client curl libcurl4-openssl-dev libc-client2007e-dev libpq-dev libxslt1-dev autoconf wget nano libseccomp-dev libsqlite3-dev procps php-xdebug python3 python3-dev python3-pip nginx default-jre libpci-dev xvfb sudo libjpeg-dev libpng-dev libkrb5-dev unzip libffi-dev coreutils manpages-dev man-db pcregrep libmariadb-dev

RUN pip3 install requests

# Install freetype (needed by Drupal)
RUN wget https://download.savannah.gnu.org/releases/freetype/freetype-2.9.1.tar.gz
RUN tar -xvf freetype-2.9.1.tar.gz
WORKDIR freetype-2.9.1
RUN ./configure --prefix=/usr
RUN make
RUN make install
WORKDIR /
RUN cp freetype-2.9.1/builds/unix/freetype-config /usr/bin

# Install golang
RUN wget -O go1.13.8.linux-amd64.tar.gz https://dl.google.com/go/go1.13.8.linux-amd64.tar.gz
RUN tar -C /usr/local -xzf go1.13.8.linux-amd64.tar.gz

# Copy updated nginx conf to allow for php
COPY ./testing/nginx_conf /etc/nginx/sites-enabled/default

COPY ./testing/create_user.sql /root/testing/create_user.sql
RUN /etc/init.d/mysql start && mysql -u root < "/root/testing/create_user.sql"

# Copy stages and unzip zip files
COPY ./stage1 /root/stage1
COPY ./stage2 /root/stage2
COPY ./stage3 /root/stage3
COPY ./php-src /root/php-src
COPY ./vm_scripts /root/vm_scripts
COPY ./go.zip /root/go.zip
RUN unzip -q /root/go.zip -d /root
COPY ./phpMyAdmin.zip /root/phpMyAdmin.zip
RUN unzip -q /root/phpMyAdmin.zip -d /root
COPY ./Drupal.zip /root/Drupal.zip
RUN unzip -q /root/Drupal.zip -d /root
COPY ./Joomla.zip /root/Joomla.zip
RUN unzip -q /root/Joomla.zip -d /root

# Copy databases for Joomla and drupal
COPY ./testing/Joomla.sql /root/Joomla.sql
COPY ./testing/drupal.sql /root/drupal.sql

RUN ln -s /usr/lib/libc-client.a /usr/lib/x86_64-linux-gnu/libc-client.a

ENV PATH "$PATH:/usr/local/go/bin"
