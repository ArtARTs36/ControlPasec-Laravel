FROM phpdockerio/php73-fpm:latest
WORKDIR "/"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install  php7.3-pgsql php7.3-gd php-redis \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install git
RUN apt-get update \
    && apt-get -y install git \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install npm
RUN apt-get update && apt-get install -y npm

RUN apt-get install zip

RUN apt-get update \
    && apt-get -y install curl dirmngr apt-transport-https lsb-release ca-certificates \
    && curl -sL https://deb.nodesource.com/setup_12.x | bash -

RUN apt-get update && apt-get -y install nodejs

# Install yarn
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
    && echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list

RUN apt-get update

RUN apt-get -y install yarn

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && rm composer-setup.php \
    && mv composer.phar /usr/local/bin/composer
