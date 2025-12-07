FROM php:8.2-apache

# Instalar dependências do Laravel e extensões do PHP
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring gd

# Habilitar o mod_rewrite do Apache
RUN a2enmod rewrite

# Definir diretório de trabalho
WORKDIR /var/www/html

# Permissões (essencial pro Laravel)
RUN chown -R www-data:www-data /var/www/html
