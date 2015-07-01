<?php

/* @var $this yii\web\View */
/* @var $model \modules\users\models\backend\Users */

$this->title = 'Пользователи';
$this->params['pageTitle'] = $this->title;
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->login, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>

<div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>