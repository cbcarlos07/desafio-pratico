# docker-mysql-php73-phpmyadmin
# docker-php73


Problemas com composer

apt-get remove composer
apt-get update
apt-get install curl
curl -s https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

https://stackoverflow.com/a/68149438/6754506




# Após instalar o laravel

 chmod 777 -R storage/

## Adicionar o alias no apache

Modificar o arquivo 

/etc/apache2/sites-available/000-default.conf

    Alias /backend /var/www/html/backend/public

	<Directory /var/www/html/backend/public >

		Options Indexes FollowSymLinks

		AllowOverride All

		Require all granted

	</Directory>


service apache2 restart


## Relembrar

https://www.devmedia.com.br/laravel-tutorial/33173

Controller 

    php artisan make:controller PagesController

## Problema de encontrar controller

https://stackoverflow.com/a/63959438/6754506

## Quando alteração em algum arquivo não tiver efeito

Seguir o seguinte caminho

    /usr/local/etc/php/conf.d

Trocar de

    opcache.enable = 1

Para 

    opcache.enable = 0

## Cors Laravel

For me i put this codes in public\index.php file. and it worked just fine for all CRUD operations.

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS, post, get');
header("Access-Control-Max-Age", "3600");
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
header("Access-Control-Allow-Credentials", "true");


Fonte:  https://stackoverflow.com/a/59915486/6754506

## Criar banco de dados e tabela

    php artisan mysql:createdb

    php artisan migrate --path=/database/migrations/2022_02_02_153045_create_product_table.php