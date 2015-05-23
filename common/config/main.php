<?php
$config = [
    'name' => 'Rakovskiy',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'defaultRoute' => 'main/default',
    'bootstrap' => [
        'modules\main\Bootstrap',
        'modules\users\Bootstrap',
    ],
    'language' => 'ru',
    'components' => [
        'user' => [
            'class' => 'modules\users\components\User',
            'identityClass' => 'modules\users\models\Users',
            'enableAutoLogin' => true,
            'loginUrl' => ['/users/guest/login'],
        ],
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
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '-9rZMynEaQwPy0Qv1HZSCwgeFUlB9Unz',
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;