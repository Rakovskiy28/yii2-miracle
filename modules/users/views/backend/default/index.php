<?php
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['pageTitle'] = $this->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-groups-index">

    <?php if (Yii::$app->user->can('users_crud')): ?>
        <p>
            <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <?php Pjax::begin() ?>

    <?= $this->render('_view', [
        'dataProvider' => $dataProvider
    ]) ?>

    <?php Pjax::end() ?>

</div>
