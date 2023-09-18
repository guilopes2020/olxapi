# API Olx

    API feita com Laravel 9 usando a arquitetura DDD (domain driven design) e tambem com testes TDD (testes unitários e features)

### Instalação
    abra o terminal e va ate a pasta onde ficam seus projetos;
    faça o clone do projeto: git clone https://github.com/guilopes2020/olxapi.git

    entre na pasta do projeto:
    cd olxapi

    crie um novo banco de dados: exemplo(olxapi)
    
    troque as variaveis de ambiente no arquivo .env para as suas informações locais:
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=olxapi
    DB_USERNAME=user
    DB_PASSWORD=password

    gere um nova APP_KEY com o comando:
    php artisan key:generate

    Rode as migrates e seeders do projeto:
    php artisan migrate:fresh --seed

### Para rodar testes
    php artisan test

### Para rodar o servidor
    php artisan serve