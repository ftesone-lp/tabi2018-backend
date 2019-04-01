tabi2018-backend
================

## Trabajo final de la materia Tecnologías Aplicadas para Business Intelligence - Cursada 2018

Para ejecutar el proyecto es necesario tener instalado docker.

Para crear la imagen con tag `tabi2018/ftesone-backend:latest` debe ejecutarse el siguiente comando desde la carpeta raíz del repositorio:

```bash
bash ./docker/bin/build.sh
```

Para ejecutar la aplicación sobre el puerto 8000 de la máquina anfitriona:

```bash
bash ./docker/bin/run.sh
```

Para ejecutar la aplicación sobre el puerto *PORT* de la máquina anfitriona:

```bash
bash ./docker/bin/run.sh PORT
```
