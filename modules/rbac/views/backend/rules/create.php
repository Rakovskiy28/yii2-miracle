<?php

/* @var $this yii\web\View */
/* @var $model \modules\rbac\models\RolesForm */

$this->title = 'Роли пользователей';
$this->params['pageTitle'] = $this->title;
$this->params['breadcrumbs'][] = ['label' => 'Роли пользователей', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Добавить';
?>

<div>
    <?= $this->render('_form', [
        'model' => $model
    ]) ?>
</div>
