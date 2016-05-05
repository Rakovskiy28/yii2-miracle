<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \modules\users\models\frontend\Users */

$this->title = $model->login;
$this->params['pageTitle'] = $this->title;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->login;
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => 'MiracleCMS, ' . $model->login . ', личная страничка, профиль, пользователь'
]);
$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Личная страничка ' . $model->login . ', личные данные, профиль юзера'
]);
?>

<div class="col-lg-12">
    <div class="pull-left">
        <a href="<?= $model->getUrlAvatar() ?>">
            <img src="<?= $model->getUrlAvatar() ?>" alt="<?= $model->login ?>"/>
        </a>
    </div>
    <div class="col-lg-12">
        <div>
            <strong>Логин:</strong> <?= $model->login ?>
        </div>
        <div>
            <strong>Пол:</strong> <?= $model->sex == 'w' ? 'Женский' : 'Мужской' ?>
        </div>
        <div>
            <strong>Дата регистрации:</strong> <?= Yii::$app->formatter->asDatetime($model->time_reg) ?>
        </div>
        <div>
            <strong>Последняя авторизация:</strong> <?= Yii::$app->formatter->asDatetime($model->time_login) ?>
        </div>
    </div>
</div>