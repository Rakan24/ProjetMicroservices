# Utilisation de l'image PHP avec Apache
FROM php:8.0-apache

# Activer les modules nécessaires pour Apache
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev && docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install gd

# Copie des fichiers du projet dans le répertoire de travail du conteneur
COPY . /var/www/html/

# Exposer le port par défaut Apache
EXPOSE 80
