FROM php:7.3

RUN apt-get update

# 1. development packages
RUN apt-get install -y \
    git \
    zip \
    curl \
    sudo \
    unzip \
    openssl \
    libicu-dev \
    libbz2-dev \
    libzip-dev \
    libgmp-dev \
    file

#RUN apt-get update && apt-get install -y libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/*
#RUN pecl install imagick-beta

RUN apt-get update && apt-get install -y \
    libmagickwand-dev --no-install-recommends \
    && pecl install imagick \
    && docker-php-ext-enable imagick

RUN curl -sS https://getcomposer.org/installer | php -- \
--install-dir=/usr/bin --filename=composer && chmod +x /usr/bin/composer

RUN ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/local/include/
RUN docker-php-ext-configure gmp
RUN docker-php-ext-install gmp

RUN mkdir /app

WORKDIR /app
COPY . /app

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install \
    --no-ansi \
    --no-autoloader \
    --no-interaction \
    --no-scripts


CMD php artisan serve --host=0.0.0.0 --port=8000
EXPOSE 8000


