<?php
use yii\grid\GridView;

$columns = [];

if (Yii::$app->user->can('roles_crud')) {
    $columns[] = ['class' => 'yii\grid\CheckboxColumn'];
}

$columns[] = [
    'class' => 'yii\grid\DataColumn',
    'attribute' => 'Алиас',
    'value' => 'name'
];

$columns[] = [
    'class' => 'yii\grid\DataColumn',
    'attribute' => 'Название',
    'value' => 'description'
];

if (Yii::$app->user->can('roles_crud')) {
    $columns[] = ['class' => 'yii\grid\ActionColumn'];
}

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
]);