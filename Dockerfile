# Resmi PHP ve Apache sunucu görüntüsünü kullanın
FROM php:8.1-apache

# Uygulamanızın kodunu /var/www/html içine kopyalayın
COPY . /var/www/html

# Gerekli PHP eklentilerini yükleyin
RUN docker-php-ext-install pdo pdo_mysql

# Apache mod_rewrite'i etkinleştirin (örneğin .htaccess dosyalarını kullanmak için)
RUN a2enmod rewrite

# Giriş noktanızı belirleyin (örneğin Laravel projenizin public dizini)
WORKDIR /var/www/html
