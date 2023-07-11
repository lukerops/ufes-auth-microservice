# Microsserviço de autentificação

Esse projeto é um microsserviço capaz de:

- Criar e manter usuários, com diferentes permissões;
- Gerenciar tokens de autentificação para verificar se usuário esta logado.

Para tanto, utilizamos dois containers: um pro laravel e outro pro banco de dados.

## Como iniciar o microsserviço

Clone o repositório do projeto

```sh
git clone https://github.com/lukerops/ufes-auth-microservice.git laravel-10
```

Entre na pasta criada

```sh
cd laravel-10/
```

## Configuração do ambiente

Caso seja a primeira vez que você inicia o projeto no seu ambiente, siga esse passo a passo. Caso contrário, pule para a seção [utilize o microsserviço.](#utilize-o-microsserviço)

### Crie o Arquivo com as configurações do ambiente

Esse arquivo se chama .env e o projeto fornece um exemplo para testes.

```sh
cp .env.example .env
```

### Suba os containers do microsserviço

```sh
docker-compose up -d
```

### Acesse o container

```sh
docker-compose exec app bash
```

### Instale as dependências do projeto

```sh
composer install
```

### Gere a key do projeto Laravel

```sh
php artisan key:generate
```

### Realiza as migrações

```sh
php artisan migrate
```

## Utilize o microsserviço

Caso ainda não tenha os containers rodando, repita o comando para subir os containers [aqui](#suba-os-containers-do-microsserviço).

### Acesse o projeto

Se a configuração foi feita de acordo com o arquivo exemplo, o projeto estará rodando no link abaixo.

[http://localhost:8989](http://localhost:8989)
