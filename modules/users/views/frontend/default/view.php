<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \modules\users\models\frontend\Users */

$this->title = $model->login;
$this->params['pageTitle'] = $this->title;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->login;
?>

<div class="col-lg-12">
    <div class="pull-left">
        <?php if ($model->fileUrl !== null): ?>
            <img src="<?= $model->fileUrl ?>" alt="<?= $model->login ?>"/>
        <?php else: ?>
            <img src="http://kinoreactor.ru/templates/Kinoreactor/dleimages/noavatar.png" alt=""/>
        <?php endif; ?>
    </div>
    <div class="col-lg-12">
        <div>
            <strong>Логин:</strong> <?= $model->login ?>
        </div>
        <div>
            <strong>Пол:</strong> <?= $model->sex == 'w' ? 'Женский' : 'Мужской' ?>
        </div>
        <div>
            <strong>Дата регистрации:</strong> <?= date('d/m/Y в H:i:s', $model->time_reg) ?>
        </div>
        <div>
            <strong>Последняя авторизация:</strong> <?= date('d/m/Y в H:i:s', $model->time_login) ?>
        </div>
    </div>
</div>