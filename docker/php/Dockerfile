FROM php:8.0.7-fpm
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
    git \
    zip \
    unzip \
    wget \
    libzip-dev \
    librabbitmq-dev \
    libpq-dev \
    && docker-php-ext-install pdo_mysql

#ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

#RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
#    install-php-extensions amqp calendar xsl memcached xml xdebug-3.0.0
#RUN pecl install amqp && docker-php-ext-enable amqp
COPY php.ini $PHP_INI_DIR/php.ini

RUN curl -sS https://getcomposer.org/installer | php \
    -- --install-dir=${COMPOSER_HOME:-/usr/local/bin} \
    --filename=composer

RUN composer self-update
ENV COMPOSER_MEMORY_LIMIT=-1
ARG USER_UID=1000
ARG USER_GID=1000
ARG USER_NAME='www-data'
ARG USER_GROUP='www-data'
RUN groupadd $USER_GROUP --gid $USER_GID
RUN useradd -g $USER_GROUP -u $USER_UID $USER_NAME -m

USER $USER_NAME:$USER_GROUP

CMD ["php-fpm"]