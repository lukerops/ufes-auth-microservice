#!/bin/bash

#criando network
if ! docker network inspect auth_mysql_network >/dev/null 2>&1; then
  docker network create auth_mysql_network
fi
#criando e configurando imagem e network do aplicativo flask
docker build -t auth_swagger_server -f Dockerfile .

#criando e configurando imagem e network do aplicativo mysql
docker build -t auth_mysql -f Dockerfile_BancoDados .
