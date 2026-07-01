FROM php:8.4-cli

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql mysqli zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

CMD ["tail", "-f", "/dev/null"]