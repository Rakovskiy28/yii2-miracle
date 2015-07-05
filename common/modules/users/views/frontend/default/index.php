<?php

use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel modules\users\models\frontend\UsersSearch */

$this->title = 'Пользователи';
$this->params['pageTitle'] = $this->title;
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => 'MiracleCMS, CMS, Пользователи, Модуль, Юзеры, Фильтр'
]);
$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Просмотр всех пользователей, список юзеров, поиск по фильтру'
]);
?>

<div class="col-lg-10">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'login',
            [
                'attribute' => 'sex',
                'value' => function ($model, $key, $index, $column) {
                    return $model['sex'] === 'w' ? 'Женский' : 'Мужской';
                },
            ],
            'time_reg:datetime',
            'time_login:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '<div class="text-center">{view}</div>'
            ]
        ],
    ]) ?>
</div>

<div class="col-lg-2 panel panel-info panel-heading">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($searchModel, 'login') ?>

    <?= $form->field($searchModel, 'sex')->radioList([
        'm' => 'Мужской',
        'w' => 'Женский',
    ]) ?>

    <?= $form->field($searchModel, 'avatar')->checkboxList([
        '1' => 'Только с аватаром'
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary col-lg-12 col-xs-12']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>