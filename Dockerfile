FROM php:8.2

RUN apt-get update && apt-get install -y \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo_mysql mbstring bcmath xml zip pcntl sockets

WORKDIR /var/www

COPY . .

RUN composer install

RUN php artisan key:generate

RUN php artisan test

EXPOSE 8000

CMD ["php", "artisan", "octane:start", "--workers=4", "--server=frankenphp", "--host=0.0.0.0", "--port=8000"]
