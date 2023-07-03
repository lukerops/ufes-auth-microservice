## Passo a passo para rodar o projeto
Clone o projeto
```sh
git clone https://github.com/EricRabelo/Auth-Micro-Service.git laravel-10
```
```sh
cd laravel-10/
```
#### configuração do ambiente

Crie o Arquivo .env
```sh
cp .env.example .env
```

Suba os containers do projeto
```sh
docker-compose up -d
```

Acesse o container
```sh
docker-compose exec app bash
```

Instale as dependências do projeto
```sh
composer install
```

Gere a key do projeto Laravel
```sh
php artisan key:generate
```

Realiza as migrações
```sh
php artisan migrate
```

Acesse o projeto
[http://localhost:8989](http://localhost:8989)
