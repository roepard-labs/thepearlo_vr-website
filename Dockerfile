FROM php:8.3-fpm

# Instalar todas las dependencias del sistema y extensiones PHP en un solo RUN
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libmariadb-dev-compat \
    libmariadb-dev \
    zip \
    unzip \
    curl \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
    mysqli \
    gd \
    opcache \
    zip \
    mbstring \
    exif \
    pcntl \
    bcmath \
    sockets \
    && rm -rf /var/lib/apt/lists/*

# Copiar código fuente y configurar permisos
COPY . /var/www/html
WORKDIR /var/www/html

# SEGURIDAD: Eliminar archivos sensibles que no deberían estar en la imagen
RUN rm -f /var/www/html/.env \
    && rm -f /var/www/html/.env.* \
    && rm -rf /var/www/html/.git \
    && rm -f /var/www/html/.gitignore \
    && rm -f /var/www/html/.dockerignore

# Crear un .env vacío como placeholder (Dokploy lo sobrescribirá)
RUN touch /var/www/html/.env \
    && chmod 600 /var/www/html/.env \
    && chown www-data:www-data /var/www/html/.env

# Configurar permisos base
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Proteger directorios críticos del frontend (no accesibles desde web)
RUN chmod 750 /var/www/html/layout \
    && chmod 750 /var/www/html/layouts \
    && chmod 750 /var/www/html/ui \
    && chmod 750 /var/www/html/utils \
    && chmod 750 /var/www/html/scripts \
    && chmod 750 /var/www/html/pages

# Proteger archivos de configuración generados
RUN if [ -f /var/www/html/js/config.js ]; then chmod 644 /var/www/html/js/config.js; fi

# Configurar Nginx
COPY ./nginx.conf /etc/nginx/sites-available/default
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default \
    && rm -f /etc/nginx/sites-enabled/default.conf \
    && rm -f /etc/nginx/conf.d/default.conf

# Configurar PHP-FPM y Supervisord
COPY ./php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Verificar configuración de Nginx antes de iniciar
RUN nginx -t

# Exponer puerto y comando de inicio
EXPOSE 3000
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]