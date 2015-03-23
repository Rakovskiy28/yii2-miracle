<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Роли пользователей';
$this->params['pageTitle'] = $this->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-groups-index">

    <?= Html::beginForm(['delete-multiple']); ?>

    <?php if (Yii::$app->user->can('roles_crud')): ?>
        <p>
            <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
            <?= Html::submitButton('Удалить', ['class' => 'btn btn-danger']) ?>
        </p>
    <?php endif; ?>

    <?= $this->render('_view', [
        'dataProvider' => $dataProvider
    ]) ?>

    <?= Html::endForm(); ?>

</div>
