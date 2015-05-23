<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'main' => [
            'class' => 'modules\main\Module',
        ],
    ],
    'components' => [
        'request' => [
            'baseUrl' => '',
            'cookieValidationKey' => '-9rZMynEaQwPy0Qv1HZSCwgeFUlB9Unz'
        ],
        'errorHandler' => [
            'errorAction' => 'index/error',
        ],
        'view' => [
            'theme' => 'themes\bare\Theme'
        ],
    ],
    'params' => $params,
];