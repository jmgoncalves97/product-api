# Adicionar o diretório de binários do Composer ao PATH
# export PATH="$PATH:$HOME/.config/composer/vendor/bin"

# Atualizar
sudo apt-get update

# Instalar o MySQL
sudo apt-get install mysql-server

# Iniciar o MySQL
sudo service mysql start

# Criar banco
sudo mysqladmin -u root CREATE product_api;

# Criar usuario laravel e dar permissão
sudo mysql -u root -e "CREATE USER 'laravel'@'localhost' IDENTIFIED BY '';"
sudo mysql -u root -e "GRANT ALL PRIVILEGES ON product_api.* TO 'laravel'@'localhost'"

# Gerar a chave
php artisan key:generate

# Rodar migrations
sudo php artisan migrate

# Gerar swagger.json
./vendor/bin/openapi --bootstrap vendor/autoload.php --output public/swagger.json app/

# Rodar testes unitários
php artisan test

# Starta a aplicação
PHP_CLI_SERVER_WORKERS=2 php artisan serve --port 8001