# biblioteca
API RESTful que simula o sistema de gerenciamento de uma biblioteca.

php 8.2

# Instale as dependências
composer install

# Configure o arquivo de ambiente
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate

# Execute as migrations
php artisan migrate

# Inicie o servidor local
php artisan serve
