#!/bin/bash

# Executa o contêiner do MySQL com o redirecionamento de saída apropriado
docker run -d --rm --network auth_mysql_network -v /banco:/var/lib/mysql --name auth_mysql_cont --log-driver=json-file --log-opt max-size=10m --log-opt max-file=3 auth_mysql > /dev/null 2>&1

# Executa o contêiner do Swagger Server com o redirecionamento de saída apropriado1
docker run -d --rm -p 8080:8080 --network auth_mysql_network -v .:/usr/src/app --name swagger_server_cont --log-driver=json-file --log-opt max-size=10m --log-opt max-file=3 auth_swagger_server > /dev/null 2>&1
