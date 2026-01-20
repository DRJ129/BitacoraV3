FROM node:18-alpine AS node-builder
WORKDIR /var/www
COPY package*.json ./
RUN npm ci --silent
COPY . .
RUN npm run build --silent

FROM php:8.2-fpm
WORKDIR /var/www
RUN apt-get update && apt-get install -y \
    git zip unzip libzip-dev libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev libicu-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip intl \
 && rm -rf /var/lib/apt/lists/*
COPY --from=node-builder /var/www/public/build /var/www/public/build
COPY --from=node-builder /var/www/public /var/www/public
COPY --from=node-builder /var/www/node_modules /var/www/node_modules
COPY --from=node-builder /var/www/package*.json /var/www/
COPY composer.json composer.lock /var/www/
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --no-interaction --optimize-autoloader --no-scripts
COPY . /var/www
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
EXPOSE 9000
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["php-fpm"]
