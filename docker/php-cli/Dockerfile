FROM php:8.2-cli
RUN apt-get update && apt-get install -y git iputils-ping nano libpq-dev bash \
    autoconf g++ make \
    && pecl install xdebug \
#    Удаляем временные файлы пекла
    && rm -rf /tmp/pear \
    && docker-php-ext-enable xdebug

# Install Composer --------------------------------------
COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1
#------------------------

RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install pdo_pgsql

#Устанавливаем Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash && \
     mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

#Добавляем пользователя и группу с хоста ------------------------
ARG USER_ID
ARG GROUP_ID

RUN addgroup --gid ${GROUP_ID} user
RUN adduser --disabled-password --gecos '' --uid ${USER_ID} --gid ${GROUP_ID} user
USER user
#------------------------

#Добавляем настройки xdebug'a в php
COPY ./php/conf.d/xdebug.ini /usr/local/etc/php/conf.d

WORKDIR /app
EXPOSE 9000