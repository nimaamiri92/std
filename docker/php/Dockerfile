FROM php:7.4-fpm

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions gd xdebug

RUN apt-get update &&  apt-get install -y \
    gcc \
    musl-dev \
    autoconf \
    zlib1g-dev \
    zip \
    vim \
    unzip \
    wget \
    git \
    libzip-dev \
    libxml2-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    && docker-php-ext-install -j$(nproc) pdo pdo_mysql bcmath zip pcntl soap  \
    && docker-php-ext-configure gd --with-jpeg  \
    && docker-php-ext-install gd \
    && pecl install redis-4.1.1  \
    && docker-php-ext-enable redis



RUN apt-get update && apt-get install -y libpng-dev
RUN apt-get install -y \
    libwebp-dev \
    libjpeg62-turbo-dev \
    libpng-dev libxpm-dev \
    libfreetype6-dev

RUN docker-php-ext-configure gd


#RUN pecl install xdebug \
#    && docker-php-ext-enable xdebug

RUN  install-php-extensions xdebug  && docker-php-ext-enable xdebug; \

    echo "xdebug.mode=develop,profile,gcstats,coverage,debug,trace" >> /usr/local/etc/php/conf.d/xdebug.ini; \
    echo "xdebug.idekey=mono-key" >> /usr/local/etc/php/conf.d/xdebug.ini; \
    echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug.ini
#    echo "xdebug.client_host=192.168.1.105" >> /usr/local/etc/php/conf.d/xdebug.ini



# Installing composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer


COPY --chown=www-data:www-data . .