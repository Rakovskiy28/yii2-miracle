<?php

/* @var $this yii\web\View */
/* @var $model \modules\users\models\backend\Users */

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