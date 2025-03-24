FROM php:8.2-fpm-alpine

COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini.disabled

# persistent / runtime deps
RUN apk add --no-cache \
    acl \
    fcgi \
    file \
    gettext \
    git \
    icu-dev \
    libzip-dev \
    zlib-dev \
    bash \
    jq \
    wget \
    ;

RUN docker-php-ext-configure zip
RUN docker-php-ext-install -j$(nproc) \
		intl \
		zip \
	;

ENV COMPOSER_HOME /var/www/.composer

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer
RUN composer self-update
RUN chown 1000:1000 /usr/local/bin/composer

RUN mkdir -p /var/www/.composer && chown 1000:1000 /var/www/.composer

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions
RUN install-php-extensions pdo_mysql xdebug-^3

RUN echo 'memory_limit = 512M' >> /usr/local/etc/php/php.ini
RUN cp /usr/local/etc/php/php.ini /usr/local/etc/php/php-cli.ini \
    && echo 'memory_limit = -1' >> /usr/local/etc/php/php-cli.ini \
    && echo 'max_execution_time = -1' >> /usr/local/etc/php/php-cli.ini \
    && rm -f /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini



#RUN version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
#    && architecture=$(uname -m) \
#    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/linux/$architecture/$version \
#    && mkdir -p /tmp/blackfire \
#    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp/blackfire \
#    && mv /tmp/blackfire/blackfire-*.so $(php -r "echo ini_get ('extension_dir');")/blackfire.so \
#    && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8307\n" > $PHP_INI_DIR/conf.d/blackfire.ini \
#    && rm -rf /tmp/blackfire /tmp/blackfire-probe.tar.gz
#
#
#RUN mkdir -p /tmp/blackfire \
#    && architecture=$(uname -m) \
#    && curl -A "Docker" -L https://blackfire.io/api/v1/releases/cli/linux/$architecture | tar zxp -C /tmp/blackfire \
#    && mv /tmp/blackfire/blackfire /usr/bin/blackfire \
#    && rm -Rf /tmp/blackfire

