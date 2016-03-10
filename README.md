## Install


If asset plugin not installed yet:
    
- `composer global require "fxp/composer-asset-plugin:~1.1.1"


Install depends:

- `composer install`


Install yii2

- `php init`
- `0`
- `yes`


RBAC files:

- `chmod 666 common/modules/rbac/data/assignments.php`
- `chmod 666 common/modules/rbac/data/items.php`
- `chmod 666 common/modules/rbac/data/rules.php`


Fill DB access /common/config/main-local.php

Migrations
    
- `php yii migrate --migrationPath=@modules/users/migrations`


Nginx config:

    server {
    	charset utf-8;
    
    	listen 80;
    	listen [::]:80;
    
    	server_name example.loc www.example.loc;
    	root        /path/to/example.loc;
    	index       index.php;
    
        location /files {
              alias /path/to/example.loc/common/files/;
        }
        
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
Do not forget change "/path/to/example.loc" and "example.loc" to your own.
