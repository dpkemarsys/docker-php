# Use an official Python runtime as a base image
FROM php:7.1-apache

RUN apt-get update && \
    apt-get install --yes --force-yes \
    cron g++ gettext libicu-dev openssl \
    libc-client-dev libkrb5-dev  \
    libxml2-dev libfreetype6-dev \
    libgd-dev libmcrypt-dev bzip2 \
    libbz2-dev libtidy-dev libcurl4-openssl-dev \
    libz-dev libmemcached-dev libxslt-dev git-core


# PHP Configuration
RUN docker-php-ext-install bcmath &&\
    docker-php-ext-install bz2 && \
    docker-php-ext-install calendar && \
    docker-php-ext-install dba && \
    docker-php-ext-install exif &&\
    docker-php-ext-configure gd --with-freetype-dir=/usr --with-jpeg-dir=/usr &&\
    docker-php-ext-install gd &&\
    docker-php-ext-install gettext &&\
    docker-php-ext-configure imap --with-kerberos --with-imap-ssl &&\
    docker-php-ext-install imap &&\
    docker-php-ext-install intl &&\
    docker-php-ext-install mcrypt &&\
    docker-php-ext-install pdo pdo_mysql &&\
    docker-php-ext-install soap &&\
    docker-php-ext-install tidy &&\
    docker-php-ext-install xmlrpc &&\
    docker-php-ext-install mbstring &&\
    docker-php-ext-install xsl &&\
    docker-php-ext-install zip &&\
    docker-php-ext-configure hash --with-mhash &&\
    pecl install xdebug && docker-php-ext-enable xdebug &&\
    pecl install mongodb && docker-php-ext-enable mongodb &&\
    curl -sS https://getcomposer.org/installer | php \
            && mv composer.phar /usr/bin/composer

# Apache Configuration
RUN a2enmod rewrite 

# SSL
RUN mv  /etc/apache2/sites-available/default-ssl.conf /etc/apache2/sites-available/000-default-ssl.conf &&\
    a2enmod ssl && \
    a2ensite 000-default-ssl &&\
    openssl req -subj '/CN=example.com/O=My Company Name LTD./C=US' -new -newkey rsa:2048 -days 365 -nodes -x509 -keyout /etc/ssl/private/ssl-cert-snakeoil.key -out /etc/ssl/certs/ssl-cert-snakeoil.pem

EXPOSE 443

# Imagemagick
RUN apt-get install --yes --force-yes libmagickwand-dev libmagickcore-dev
RUN yes '' | pecl install -f imagick &&\
    docker-php-ext-enable imagick

COPY create_vhost start /usr/local/bin/
COPY php.ini /usr/local/etc/php/

CMD ["start"]