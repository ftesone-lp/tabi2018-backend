tabi2018-backend
================

## Trabajo final de la materia Tecnologías Aplicadas para Business Intelligence - Cursada 2018

Para ejecutar el proyecto es necesario tener instalado docker.

Para crear la imagen debe ejecutarse el siguiente comando desde la carpeta raíz del repositorio:

`docker build docker --tag tabi2018/ftesone-backend:latest`

Para ejecutar la aplicación sobre el puerto 8080 de la máquina anfitriona (puede elegirse cualquier puerto):

``docker run -it --rm -p8080:8000 -v `pwd`:/code tabi2018/ftesone-backend:latest``
