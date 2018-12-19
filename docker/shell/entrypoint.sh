#!/bin/sh

# instalar dependencias del proyecto
composer update

# borrar cache y logs
rm -r var/cache/*
rm -r var/log/*

# iniciar mysql y crear bd
service mysql start
mysql -u root -proot -e "CREATE DATABASE agricultura;"
mysql -u root -proot -D agricultura < db/agricultura.sql
mysql -u root -proot -e "CREATE USER 'tabi2018'@'%' IDENTIFIED BY 'tabi2018';"
mysql -u root -proot -e "GRANT ALL PRIVILEGES ON *.* TO 'tabi2018'@'%';"
mysql -u root -proot -e "FLUSH PRIVILEGES;"
service mysql restart

# iniciar servidor
php bin/console server:run 0.0.0.0:8000
