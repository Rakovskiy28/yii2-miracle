<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \modules\users\models\backend\Users */

$this->title = 'Пользователи';
$this->params['pageTitle'] = $this->title;
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->login;
?>

<div>

    <?php if (Yii::$app->user->can('users_crud') || Yii::$app->user->can('user', ['id' => $model->id])): ?>
        <p>
            <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
            <?php if (Yii::$app->user->can('users_crud')): ?>
                <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить данного пользователя?',
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif; ?>
        </p>
    <?php endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'login',
            [
                'attribute' => 'sex',
                'value' => $model->sex === 'w' ? 'Женский' : 'Мужской',
            ],
            'time_reg:datetime',
            'time_login:datetime',
            'ip',
            'ua'
        ],
    ]) ?>

</div>
