FROM php:7.2-stretch
# FROM php:7.2-apache-stretch

# install git, mysql
RUN apt-get update -y && apt-get upgrade -y
RUN apt-get install -y git mysql-server zip zlib1g-dev

# install php extensions
RUN docker-php-ext-install pdo pdo_mysql zip

# install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

# expose port
EXPOSE 8000

# create /code dir
RUN mkdir -p /code
VOLUME ["/code"]
WORKDIR /code

# set entrypoint
RUN mkdir -p /entrypoint
ADD ./shell/entrypoint.sh /entrypoint.sh
ENTRYPOINT ["/bin/sh", "/entrypoint.sh"]
