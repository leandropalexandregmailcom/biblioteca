# biblioteca
API RESTful que simula o sistema de gerenciamento de uma biblioteca.

# Requisitos: PHP 8.2, Composer, MySQL

composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve

# Acesse a documentação em: http://127.0.0.1:8000/api/documentation

# Nota: Configure o banco de dados e o e-mail no arquivo .env
#        - Para o banco de dados, ajuste as variáveis DB_*.
#        - Para o e-mail, ajuste as variáveis MAIL_*.
