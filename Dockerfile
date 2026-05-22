FROM php:8.2-cli

WORKDIR /app

COPY . .

RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libzip-dev \
    libpq-dev \
    zip \
    npm

RUN docker-php-ext-install zip pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install
RUN npm install
RUN npm run build

RUN mkdir -p storage/framework/cache/data
RUN mkdir -p storage/framework/sessions
RUN mkdir -p storage/framework/views
RUN mkdir -p storage/logs

RUN chmod -R 775 storage bootstrap/cache

EXPOSE 10000

CMD sh -c "php artisan migrate:fresh --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=10000"