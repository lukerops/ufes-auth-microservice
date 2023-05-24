#!/bin/bash

outputMysql="mysql_container.log"
outputSwagger="swagger_container.log"

# Verifica se o parâmetro --noLog foi fornecido
if [[ "$1" == "--noLog" ]]; then
  outputMysql="/dev/null 2>&1"
  outputSwagger="/dev/null 2>&1"
fi

# Executa o contêiner do MySQL com o redirecionamento de saída apropriado
docker run --rm -d --network auth_mysql_network -v /banco:/var/lib/mysql --name auth_mysql_cont auth_mysql > $(outputMysql)

# Executa o contêiner do Swagger Server com o redirecionamento de saída apropriado1
docker run --rm -d --network auth_mysql_network -v .:/usr/src/app --name swagger_server_cont auth_swagger_server > $(outputSwagger)
