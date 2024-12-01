# Utilise une image officielle PHP avec Apache
FROM php:8.2-apache

# Installe les extensions PHP nécessaires (ajoute les tiennes si besoin)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Installation de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Active les modules Apache nécessaires
RUN a2enmod rewrite

# Copie un fichier de configuration PHP personnalisé (optionnel)
COPY conf/php.ini /usr/local/etc/php/

# Définit le répertoire de travail par défaut dans le conteneur
WORKDIR /var/www/html
