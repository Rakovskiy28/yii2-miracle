<?php

use yii\helpers\Html;

Yii::$container->set('yii\grid\CheckboxColumn', [
    'options' => [
        'style' => 'width: 30px'
    ]
]);

Yii::$container->set('yii\grid\GridView', [
    'layout' => "{summary}\n{items}\n{pager}"
]);

Yii::$container->set('yii\grid\ActionColumn', [
    'buttons' => [
        'view' => function ($url, $model, $key) {
            return Html::a('<i class="glyphicon glyphicon-eye-open"></i>', $url, [
                'class' => 'btn btn-xs btn-info',
                'title' => 'Просмотр',
                'data-pjax' => 0,
            ]);
        },
        'update' => function ($url, $model, $key) {
            return Html::a('<i class="glyphicon glyphicon-pencil"></i>', $url, [
                'class' => 'btn btn-xs btn-warning',
                'title' => 'Изменить',
                'data-pjax' => 0,
            ]);
        },
        'delete' => function ($url, $model, $key) {
            return Html::a('<i class="glyphicon glyphicon-trash"></i>', $url, [
                'class' => 'btn btn-xs btn-danger', 'data-method' => 'post',
                'title' => 'Удалить',
                'data' => [
                    'pjax' => 0,
                    'confirm' => 'Вы уверены, что хотите удалить этот элемент?'
                ],
            ]);
        }
    ],
    'template' => '<div class="text-center">{update} {delete}</div>'
]);