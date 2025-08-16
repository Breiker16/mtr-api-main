FROM php:8.2-fpm-alpine

# Instalar dependencias y extensiones
RUN apk update && apk upgrade && apk add --no-cache \
    nginx \
    mysql-client \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    oniguruma-dev \
    zip \
    unzip \
    supervisor \
 && docker-php-ext-install pdo_mysql bcmath gd

# Configuración PHP
RUN echo "memory_limit=512M" > /usr/local/etc/php/conf.d/memory-limit.ini \
 && echo "expose_php = Off" >> /usr/local/etc/php/php.ini \
 && echo "max_execution_time = 30" >> /usr/local/etc/php/php.ini \
 && echo "max_input_time = 60" >> /usr/local/etc/php/php.ini \
 && echo "post_max_size = 8M" >> /usr/local/etc/php/php.ini \
 && echo "upload_max_filesize = 2M" >> /usr/local/etc/php/php.ini \
 && echo "allow_url_fopen = Off" >> /usr/local/etc/php/php.ini \
 && echo "allow_url_include = Off" >> /usr/local/etc/php/php.ini

# Usuario no-root
RUN addgroup -g 1000 www && adduser -u 1000 -G www -s /bin/sh -D www

WORKDIR /var/www/html

# Copiar código y dependencias
COPY . .

# Instalar Composer y dependencias
RUN curl -sS https://getcomposer.org/installer | php -d allow_url_fopen=On -- --install-dir=/usr/local/bin --filename=composer \
 && php -d allow_url_fopen=On /usr/local/bin/composer install --no-dev --optimize-autoloader --no-interaction --no-progress \
 && apk del --purge git curl \
 && rm -rf /var/cache/apk/* /tmp/* /var/tmp/*

# Permisos y logs
RUN chown -R www:www /var/www/html \
 && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache \
 && chmod 644 /var/www/html/.env* 2>/dev/null || true \
 && find /var/www/html -type f -name "*.php" -exec chmod 644 {} \; \
 && find /var/www/html -type d -exec chmod 755 {} \; \
 && mkdir -p /var/log/nginx /var/log/php-fpm /var/log/supervisor \
 && mkdir -p /var/lib/nginx/tmp /var/lib/nginx/logs \
 && mkdir -p /run/nginx \
 && chown -R www:www /var/log/nginx /var/log/php-fpm /var/log/supervisor \
 && chown -R www:www /var/lib/nginx \
 && chown -R www:www /run/nginx

# Nginx y Supervisor
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/default.conf /etc/nginx/conf.d/default.conf
COPY docker/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"] 