FROM php:8.2-cli

RUN apt-get update \
    && apt-get install -y git unzip libzip-dev libpng-dev \
    && docker-php-ext-install pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN cp .env.example .env \
    && composer install --no-interaction --prefer-dist --optimize-autoloader \
    && php artisan key:generate --force

EXPOSE 8000

CMD php artisan migrate --force && php artisan db:seed --force && php -S 0.0.0.0:8000 -t public
