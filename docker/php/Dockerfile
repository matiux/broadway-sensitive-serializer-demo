FROM public.ecr.aws/neprix/azp-php-8.0-ubuntu-focal-dev:RELEASE

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
    && apt-get -y upgrade \
    && apt-get install -y --no-install-recommends \
    awscli \
    graphviz #Per deptrac

RUN rm /etc/php/8.0/cli/conf.d/10-opcache.ini
RUN rm /etc/php/8.0/fpm/conf.d/10-opcache.ini
###> Fine dipendenze sviluppo

###> Code coverage
RUN apt-get update && apt-get install -y --no-install-recommends \
    inkscape \
    php-imagick
###> Fine code coverage

###> Configurazione Xdebug
COPY conf/xdebug-starter.sh /usr/local/bin/xdebug-starter
RUN chmod +x /usr/local/bin/xdebug-starter
RUN /usr/local/bin/xdebug-starter
###> Fine configurazione Xdebug

###> Configurazione tema Zsh
RUN apt-get update && apt-get install -y --no-install-recommends \
    locales

RUN locale-gen en_US.UTF-8
ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8

USER utente

COPY conf/custom-agnoster.zsh-theme /home/utente/.oh-my-zsh/custom/themes/custom-agnoster.zsh-theme
RUN sed -i "s/ZSH_THEME=\"robbyrussell\"/ZSH_THEME=\"custom-agnoster\"/" ~/.zshrc \
    && echo "DEFAULT_USER=utente" >> ~/.zshrc
###> Fine configurazione tema Zsh

###> Configurazione aws-vault e plugin zsh dentro al container
RUN sudo curl -L -o /usr/local/bin/aws-vault https://github.com/99designs/aws-vault/releases/download/v6.2.0/aws-vault-linux-amd64
RUN sudo chmod 755 /usr/local/bin/aws-vault

RUN git clone https://github.com/blimmer/zsh-aws-vault.git ~/.oh-my-zsh/custom/plugins/zsh-aws-vault \
    && sed -i.bak 's/^plugins=(\(.*\)/plugins=(zsh-aws-vault \1/' ~/.zshrc
###> Fine configurazione aws-vault e plugin zsh dentro al container

###> Configurazione Zsh Autosuggestions
RUN git clone https://github.com/zsh-users/zsh-autosuggestions ${ZSH_CUSTOM:-~/.oh-my-zsh/custom}/plugins/zsh-autosuggestions \
    && sed -i.bak 's/^plugins=(\(.*\)/plugins=(zsh-autosuggestions \1/' ~/.zshrc \
    && echo 'export ZSH_AUTOSUGGEST_HIGHLIGHT_STYLE="fg=#0cb074"' >> ~/.zshrc
###> Fine configurazione Zsh Autosuggestions

###> Configurazione bash / zsh
COPY conf/shell-custom.rc /tmp/shell-custom.rc
RUN cat /tmp/shell-custom.rc >> /home/utente/.zshrc \
    && cat /tmp/shell-custom.rc >> /home/utente/.bashrc

COPY conf/project-autocomplete /etc/bash_completion.d
###> Fine configurazione bash / zsh

USER www-data


