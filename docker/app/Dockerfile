FROM php:8.1-fpm-buster

ENV TZ="America/Sao_Paulo"
ENV ACCEPT_EULA=Y

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

USER root

RUN apt-get update \
    && apt-get install -y --no-install-recommends --no-install-suggests \
    build-essential \
    curl \
    libzip-dev \
    libssl-dev \
    libxrender-dev \
    apt-utils \
    gnupg2 \
    ca-certificates \
    libxml2-dev \
    apt-transport-https \
    zip \
    unzip \
    libfontconfig \
    fontconfig \
    libjpeg62-turbo-dev \
    libcurl4-gnutls-dev \
    xfonts-75dpi \
    xfonts-base \
    librabbitmq-dev \
    nginx \
    supervisor \
    libxslt-dev

RUN pecl install xdebug amqp

RUN docker-php-ext-install intl curl bcmath zip xml xsl pdo_mysql
RUN docker-php-ext-enable xdebug amqp

#node
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - \
    && apt-get install -y nodejs

#yarn
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
    && echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list \
    && apt update && apt -y install yarn

COPY --from=composer /usr/bin/composer /usr/bin/composer

# instalar o wkhtmltopdf
RUN curl -k -O -L https://github.com/wkhtmltopdf/packaging/releases/download/0.12.6-1/wkhtmltox_0.12.6-1.buster_amd64.deb \
    && apt-get install -y ./wkhtmltox_0.12.6-1.buster_amd64.deb \
    && rm wkhtmltox_0.12.6-1.buster_amd64.deb

COPY nginx /etc/nginx
COPY php/php-ini-overrides.ini /usr/local/etc/php/conf.d/99-overrides.ini
COPY supervisord.conf /etc/supervisord.conf

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data
RUN mkdir /var/run/nginx && chown -R www-data:www-data /var/run/nginx /var/log/nginx /var/lib/nginx /var/www

#RUN ln -s /etc/nginx/sites-available/default.conf /etc/nginx/sites-enabled/default.conf

USER www-data

WORKDIR "/var/www/html"

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]

EXPOSE 80
