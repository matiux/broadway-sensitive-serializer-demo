#!/usr/bin/env bash

WORKDIR=/var/www/app
PROJECT_TOOL=$WORKDIR/scripts/project/bin/project
PROJECT_NAME=$(basename "$(pwd)" | tr '[:upper:]' '[:lower:]')
COMPOSE_OVERRIDE=
PHP_CONTAINER=php_broadway_sensitive_serializer_demo

if [[ -f "./docker/docker-compose.override.yml" ]]; then
  COMPOSE_OVERRIDE="--file ./docker/docker-compose.override.yml"
fi

DC_BASE_COMMAND="docker-compose
    --file docker/docker-compose.yml
    ${COMPOSE_OVERRIDE}
    -p ${PROJECT_NAME}"

DC_EXEC="${DC_BASE_COMMAND}
  exec
  -u utente
  -w ${WORKDIR}
  ${PHP_CONTAINER}"

if [[ "$1" == "up" ]]; then shift 1;                              ${DC_BASE_COMMAND} up "$@"
elif [[ "$1" == "build" ]] && [[ "$2" == "php" ]]; then shift 2;  ${DC_BASE_COMMAND} build "$@" ${PHP_CONTAINER}
elif [[ "$1" == "enter-root" ]]; then                             ${DC_BASE_COMMAND} exec -u root ${PHP_CONTAINER} /bin/zsh
elif [[ "$1" == "enter" ]]; then                                  ${DC_EXEC} /bin/zsh
elif [[ "$1" == "down" ]]; then shift 1;                          ${DC_BASE_COMMAND} down "$@"
elif [[ "$1" == "purge" ]]; then                                  ${DC_BASE_COMMAND} down --rmi=all --volumes --remove-orphans
elif [[ "$1" == "log" ]]; then                                    ${DC_BASE_COMMAND} logs -f

#elif [[ "$1" == "composer" ]]; then shift 1; ${DC_EXEC} composer "$@"
elif [[ "$1" == "create-badge" ]]; then shift 1;                  ${DC_EXEC} $PROJECT_TOOL create-badge "$@"
elif [[ "$1" == "coding-standard-fix" ]]; then shift 1;           ${DC_EXEC} $PROJECT_TOOL coding-standard-fix "$@"
elif [[ "$1" == "coding-standard-check-staged" ]]; then shift 1;  ${DC_EXEC} $PROJECT_TOOL coding-standard-check-staged
elif [[ "$1" == "coding-standard-fix-staged" ]]; then shift 1;    ${DC_EXEC} $PROJECT_TOOL coding-standard-fix-staged
elif [[ "$1" == "phpunit" ]]; then shift 1;                       ${DC_EXEC} $PROJECT_TOOL coverage
elif [[ "$1" == "psalm" ]]; then shift 1;                         ${DC_EXEC} $PROJECT_TOOL psalm "$@"
elif [[ "$1" == "deptrac-all" ]]; then shift 1;                   ${DC_EXEC} $PROJECT_TOOL deptrac-all

elif [[ "$1" == "exec" ]]; then shift 1;                           ${DC_EXEC} "$@"
elif [[ $# -gt 0 ]]; then                                         ${DC_BASE_COMMAND} "$@"
else                                                              ${DC_BASE_COMMAND} ps
fi
