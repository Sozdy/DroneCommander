FROM php:8.2.1-fpm

# Arguments defined in docker-compose.local.yml
ARG user
ARG uid

ENV TZ=UTC
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update \
    && apt-get install -y gnupg curl ca-certificates zip unzip git supervisor libcap2-bin libpng-dev python2

# Install system dependencies
RUN apt-get update \
    && apt-get install -y -qq --no-install-recommends \
    libpq-dev \
    libmcrypt-dev \
    libxml2-dev \
    libgd-dev \
    libzip-dev \
    unzip \
    git \
    zip \
    curl \
    wget

RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_pgsql \
    pdo_mysql \
    opcache \
    bcmath \
    ctype \
    iconv \
    exif \
    intl \
    xml \
    zip \
    gd

## Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user && \
    mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

WORKDIR /var/www

## Set the user
USER $user
