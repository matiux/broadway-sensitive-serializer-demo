FROM matiux/php:fpm-8.1-bullseye-dev

USER root

###> Dipendenze progetto
RUN apt-get update && apt-get install -y --no-install-recommends \
    tzdata \
    unzip

ENV TZ=Europe/Rome

RUN /usr/local/bin/composer self-update
###> Fine dipendenze progetto

###> Dipendenze sviluppo
RUN apt-get update \
    && apt-get -y upgrade
###> Fine dipendenze sviluppo

###> Configurazione Xdebug
COPY conf/xdebug-starter.sh /usr/local/bin/xdebug-starter
RUN chmod +x /usr/local/bin/xdebug-starter
RUN /usr/local/bin/xdebug-starter
###> Fine configurazione Xdebug

###> Configurazione bash / zsh
COPY conf/shell-custom.rc /tmp/shell-custom.rc
RUN cat /tmp/shell-custom.rc >> /home/utente/.zshrc \
    && cat /tmp/shell-custom.rc >> /home/utente/.bashrc
###> Fine configurazione bash / zsh

USER www-data


