##Порядок установки


1. Переходим в папку с проектом
`$ cd path/to/project`

2. Устанавливаем asset плагин
`$ composer global require "fxp/composer-asset-plugin:1.0.0"`

3. Устанавливаем composer
`$ composer install`

4. Устанавливаем ФВ
`$ php init`

5. Выставляем права доступа на RBAC
`$ chmod 666 modules/rbac/data/assignments.php
$ chmod 666 modules/rbac/data/items.php
$ chmod 666 modules/rbac/data/rules.php`

6. Прописываем данные к БД в /common/config/main-local.php

7. Выполняем миграции
`$ php yii migrate --migrationPath=@modules/users/migrations`

Если у вас Nginx прописываем конфиг

server {
  	charset utf-8;
  
  	listen 80;
  	listen [::]:80;
  
  	server_name yii.loc www.yii.loc;
  	root        **<Указать директорию с сайтом>**;
  	index       index.php;
  
  	location / {
  		if ($request_uri ~ "^/backend"){
  			rewrite ^/backend/(.*)$ /backend/web/$1;
  		}
  		if ($request_uri !~ "^/backend"){
  			rewrite ^(.*)$ /frontend/web/$1;
  		}
  	}
  
  	location /frontend/web/ {
  		if (!-e $request_filename){
  			rewrite ^(.*)$ /frontend/web/index.php;
  		}
  	}
  
  	location /backend/web/ {
  		if (!-e $request_filename){
  			rewrite ^(.*)$ /backend/web/index.php;
  		}
  	}
  
  	location ~ \.php$ {
          	try_files $uri =404;
          	fastcgi_split_path_info ^(.+\.php)(/.+)$;
          	fastcgi_pass unix:/var/run/php5-fpm.sock;
          	fastcgi_index index.php;
          	include fastcgi_params;
   	}
}
