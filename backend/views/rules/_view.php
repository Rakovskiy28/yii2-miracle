<?php
use yii\grid\GridView;

$columns = [];

if (Yii::$app->user->can('rules_crud')) {
    $columns[] = ['class' => 'yii\grid\CheckboxColumn'];
}

$columns[] = [
    'class' => 'yii\grid\DataColumn',
    'attribute' => 'Название',
    'value' => 'name'
];

if (Yii::$app->user->can('rules_crud')) {
    $columns[] = [
        'class' => 'yii\grid\ActionColumn',
        'template' => '<div class="text-center">{delete}</div>'
    ];
}

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
]);