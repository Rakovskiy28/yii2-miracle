<?php
return [
    'name' => 'MiracleCMS',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'defaultRoute' => 'main/default',
    'bootstrap' => [
        'modules\main\Bootstrap',
        'modules\users\Bootstrap',
    ],
    'language' => 'ru',
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],
        'assetManager' => [
            'basePath' => '@webroot/assets',
            'baseUrl' => '@web/assets'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'defaultRoles' => ['user'],
            'itemFile' => '@modules/rbac/data/items.php',
            'assignmentFile' => '@modules/rbac/data/assignments.php',
            'ruleFile' => '@modules/rbac/data/rules.php',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
];