<?php

/* @var $this yii\web\View */
/* @var $model backend\models\Users */

$this->title = 'Пользователи';
$this->params['pageTitle'] = $this->title;
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Добавить';

$this->render('_form', [
    'model' => $model,
])
?>

<div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>