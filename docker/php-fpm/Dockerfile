FROM php:8.2-fpm
RUN apt-get update && apt-get install -y git libpq-dev \
    autoconf g++ make \
    && pecl install xdebug \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable xdebug

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

# Install Composer -------------------------
COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1
#-------------------------------------------
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install pdo_pgsql

#Добавляем настройки xdebug'a в php
COPY ./php/conf.d/xdebug.ini /usr/local/etc/php/conf.d
#Переопределяем дефолтный скрипт при запуске php-fpm,
# чтобы разрулить шлюзовый адрес и работать с xdebug и на линуксе, и на винде
COPY ./entrypoint.sh /usr/local/bin/docker-php-entrypoint
RUN chmod +x /usr/local/bin/docker-php-entrypoint

WORKDIR /app
EXPOSE 9000