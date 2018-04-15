##Image de base
FROM debian:stable

##Informations sur l'auteur
MAINTAINER Coralie LUDWIG <coralieludwig@outlook.fr>

##Téléchargement Apache, PHP et SQLite
RUN apt-get update && apt-get -y upgrade && DEBIAN_FRONTEND=noninteractive apt-get -y install apache2 php7.0 php7.0-sqlite libapache2-mod-php7.0 curl lynx-cur

##Configuration d'Apache

#Activation des modules d'apache
RUN a2enmod php7.0
RUN a2enmod rewrite

#Installation des variables d'environnement d'apache
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid

#Résolution du pb du nom du serveur
RUN echo "ServerName localhost">>/etc/apache2/httpd.conf
RUN echo "ServerName localhost">>/etc/apache2/apache2.conf

#Ouverture du port 80 côté container:
EXPOSE 80

#Mise à jour du site apache par défaut avec la configuration qu'on vient de céer
ADD apache-config.conf /etc/apache2/sites-enabled/000-default.conf

#Mise à jour des configurations php
ADD ./php.ini /usr/local/etc/php/conf.d

#Fichiers du site internet
ADD www /var/www/site

##Installation de R
ENV R_BASE_VERSION 3.3.3
RUN apt-get -y install r-base=${R_BASE_VERSION}* r-base-dev=${R_BASE_DEV_VERSION}*
RUN apt -y install libnetcdf-dev
RUN R -e 'source("http://bioconductor.org/biocLite.R")' -e 'biocLite("xcms")'

#Lancer Apache
CMD ["/usr/sbin/apache2ctl","-D","FOREGROUND"]

