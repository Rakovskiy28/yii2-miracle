<?php
use yii\grid\GridView;

$columns = [
    [
        'attribute' => 'id',
        'options' => [
            'style' => 'width: 30px;',
        ]
    ],
    'login',
    [
        'attribute' => 'sex',
        'value' => function ($model, $key, $index, $column) {
            return $model['sex'] === 'w' ? 'Женский' : 'Мужской';
        },
    ],
    [
        'attribute' => 'role',
        'format' => 'raw',
        'value' => function ($model, $key, $index, $column) {
            return isset($model->getRoles()[$model->role]) ? $model->getRoles()[$model->role] : null;
        }
    ],
    [
        'attribute' => 'time_login',
        'format' => ['date', 'php:d.m.Y в H:i:s']
    ],
    'ip'
];

if (Yii::$app->user->can('users_crud')) {
    $columns[] = [
        'class' => 'yii\grid\ActionColumn',
        'template' => '<div class="text-center">{view} {update} {delete}</div>'
    ];
}else{
    $columns[] = [
        'class' => 'yii\grid\ActionColumn',
        'template' => '<div class="text-center">{view}</div>'
    ];
}

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
]);