#!/bin/bash

# Para e remove o contêiner do banco de dados MySQL
docker stop auth_mysql_cont > /dev/null 2>&1
docker rm auth_mysql_cont > /dev/null 2>&1

# Para e remove o contêiner do aplicativo Flask
docker stop swagger_server_cont > /dev/null 2>&1
docker rm swagger_server_cont > /dev/null 2>&1