# Usa a imagem oficial do PHP com Apache
FROM php:7.4-apache

# Define a variável de ambiente TZ para o timezone desejado (por exemplo, "America/Sao_Paulo")
ENV TZ=America/Sao_Paulo

# Instala extensões PHP necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mbstring zip pdo pdo_mysql mysqli \
    && pecl install xdebug-2.9.8 \
    && docker-php-ext-enable xdebug

# Configura o timezone
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Habilita o módulo rewrite do Apache
RUN a2enmod rewrite

# Copia os arquivos do projeto para o diretório do Apache
COPY src/ /var/www/html/

# Define permissões corretas para o diretório do WordPress
# RUN chown -R www-data:www-data /var/www/html

# Aumenta os limites de upload e outras configurações no php.ini
RUN echo "upload_max_filesize = 64M" >> /usr/local/etc/php/php.ini
RUN echo "post_max_size = 64M" >> /usr/local/etc/php/php.ini
RUN echo "memory_limit = 256M" >> /usr/local/etc/php/php.ini
RUN echo "max_execution_time = 300" >> /usr/local/etc/php/php.ini

# Configura o DocumentRoot do Apache
WORKDIR /var/www/html

# Exponha a porta 80
EXPOSE 80