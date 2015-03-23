<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'defaultRoute' => 'index/index',
    'language' => 'ru',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'defaultRoles' => [
                'user'
            ],
            'itemFile' => '@app/../common/rbac/items.php',
            'assignmentFile' => '@app/../common/rbac/assignments.php',
            'ruleFile' => '@app/../common/rbac/rules.php',
        ],

    ],
];
