FROM php:8.3-fpm

WORKDIR "/admin"

ARG DOCKER_GID=1000
ARG DOCKER_UID=1000

RUN apt-get update \
    && apt-get install -y \
        libicu-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libzip-dev \
        libpng-dev \
        libpq-dev \
        libxrender-dev \
        libfontconfig \
        libxext6 \
        git \
        p7zip-full \
        net-tools iputils-ping iproute2 dnsutils\
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*


RUN docker-php-ext-install bcmath zip pdo_pgsql exif

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-configure intl \
    && docker-php-ext-install intl

RUN pecl install redis xdebug \
    && docker-php-ext-enable redis.so xdebug

RUN echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN curl https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer | php -- --quiet \
    && mv composer.phar /usr/local/bin/composer

RUN curl -sS https://get.symfony.com/cli/installer

RUN groupadd -g $DOCKER_GID dev
RUN useradd -g $DOCKER_GID -u $DOCKER_UID dev
RUN mkdir /home/dev
RUN chown -R dev:dev /home/dev

COPY services/admin /admin

USER dev