FROM matiux/php:fpm-8.1-bullseye-dev

USER root

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


