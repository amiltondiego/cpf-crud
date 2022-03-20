CPF Crud
==============================================

### Sequencia para rodar o projeto
-----
* Rodar o comando dentro da pasta para iniciar o docker-compose
* Rodar o comando que instala as dependências do composer
* Rodar o comando que faz os presets do laravel

<details>
    <summary>Se tiver o Make instalado use esses comandos para iniciar</summary>
Start para subir o docker-compose

    make start
Stop derrubar o docker-compose

    make stop
test para rodar os test de feature

    make test
composer-i para instalar as dependências do composer

    make composer-i
preset para fazer o preset do laravel

    make preset
</details>
<details>
    <summary>Caso não tenha o Make use esses comandos</summary>
Subir o docker-compose

    docker-compose up -d --build
Derrubar o docker-compose

    docker-compose down
Rodar os test de feature

    docker exec -it php-web php -d xdebug.mode=coverage artisan test --debug -vvv
Instalar as dependências do composer

    docker exec -it php-web composer install
Faz os presets do Laravel

    docker exec -it php-web cp .env.example .env && chmod -R 777 storage
</details>

### API
-----
Todas as rotas então no uri `api/`.

* Add CPF [POST] `api/cpf`
* Check CPF [GET] `api/cpf/{cpf}`
* Remove CPF [DELETE] `api/cpf/{cpf}`
* Find all CPF [GET] `api/cpf`