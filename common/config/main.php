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
            'itemFile' => '@common/rbac/items.php',
            'assignmentFile' => '@common/rbac/assignments.php',
            'ruleFile' => '@common/rbac/rules.php',
        ],

    ],
];
