<?php
use yii\grid\GridView;

$columns = [];

if (Yii::$app->user->can('permissions_crud')) {
    $columns[] = ['class' => 'yii\grid\CheckboxColumn'];
}

$columns[] = [
    'label' => 'Алиас',
    'attribute' => 'name'
];
$columns[] = [
    'label' => 'Описание',
    'attribute' => 'description'
];

if (Yii::$app->user->can('permissions_crud')) {
    $columns[] = [
        'class' => 'yii\grid\ActionColumn'
    ];
}

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns
]);