FROM php:8.1-fpm

ENV TZ Asia/Tokyo

RUN apt-get install epel-release
RUN apt-get install http://rpms.remirepo.net/enterprise/remi-release-7.rpm
RUN apt-get install httpd
RUN apt-get install --enablerepo=remi,remi-php81 php php-cli php-common php-devel php-fpm php-gd php-mbstring php-mysqlnd php-pdo php-pear php-pecl-apcu php-soap php-xml php-xmlrpc php-pecl-zip
RUN apt-get install zip unzip

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
		
COPY ./docker/app/php.ini /usr/local/etc/php/php.ini

COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

WORKDIR /app