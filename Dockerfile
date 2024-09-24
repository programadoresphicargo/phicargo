FROM php:8.2-apache

# Actualiza los repositorios e instala las dependencias necesarias
RUN apt-get update && \
    apt-get install -y --no-install-recommends libxml2-dev git unzip openssh-client libpq-dev && \
    # Instala xmlrpc desde PECL en versión beta
    pecl install channel://pecl.php.net/xmlrpc-1.0.0RC3 && \
    docker-php-ext-enable xmlrpc && \
    docker-php-ext-install mysqli pdo pdo_mysql soap pdo_pgsql && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

COPY php.ini /usr/local/etc/php/

# Copia el código fuente de la aplicación al contenedor
COPY . /var/www/html/

# Exponer el puerto 80 para la aplicación web
EXPOSE 80

