FROM matiux/php:fpm-8.1-bullseye-dev

USER root

RUN apt-get update && apt-get install -y --no-install-recommends \
    jq

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

###> Pulizia
RUN apt-get remove --purge -y software-properties-common \
    && apt-get autoremove -y \
    && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
###> Fine pulizia

USER www-data


