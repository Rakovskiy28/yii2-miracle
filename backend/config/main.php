<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'main' => [
            'class' => 'modules\main\Module',
            'isBackend' => true
        ],
        'users' => [
            'class' => 'modules\users\Module',
            'isBackend' => true
        ],
        'rbac' => [
            'class' => 'modules\rbac\Module',
            'isBackend' => true
        ],
    ],
    'components' => [
        'user' => [
            'class' => 'modules\users\components\User',
            'identityClass' => 'modules\users\models\backend\Users',
            'enableAutoLogin' => true,
            'loginUrl' => ['/users/guest/login'],
        ],
        'request' => [
            'baseUrl' => '/backend'
        ],
        'errorHandler' => [
            'errorAction' => 'main/default/error',
        ],
        'view' => [
            'theme' => 'themes\sb_admin\Theme'
        ],
    ],
    'as access' => [
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
                'allow' => true,
                'actions' => ['login', 'error', 'captcha'],
                'roles' => ['?'],
            ], [
                'allow' => true,
                'roles' => ['@'],
            ],
        ],
    ],
    'params' => $params,
];