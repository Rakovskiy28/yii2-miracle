<?php

/* @var $this yii\web\View */
/* @var $model backend\models\PermissionsForm */

$this->title = 'Права доступа';
$this->params['pageTitle'] = $this->title;
$this->params['breadcrumbs'][] = ['label' => 'Права доступа', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Добавить';
?>

<div>
    <?= $this->render('_form', [
        'model' => $model
    ]) ?>
</div>
