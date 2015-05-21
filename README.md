##Порядок установки


1. Выполняем команды

``$ cd path/to/project
$ composer global require "fxp/composer-asset-plugin:1.0.0"
$ composer install
$ php init
$ chmod 666 modules/rbac/data/assignments.php
$ chmod 666 modules/rbac/data/items.php
$ chmod 666 modules/rbac/data/rules.php
$ php yii migrate --migrationPath=@modules/users/migrations``

