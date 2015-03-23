<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model backend\models\LoginForm; */

$this->title = 'Авторизация';
?>

<h1 class="page-header"><?= Html::encode($this->title) ?></h1>

<div class="row">
    <div class="col-lg-4">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'login') ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?php if (isset($model->_user->error_auth) && $model->_user->error_auth >= 3): ?>
            <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                'captchaAction' => 'index/captcha',
                'template' => '<div class="form-group input-group">{input}<span class="input-group-addon">{image}</span></div>',
            ]) ?>
        <?php endif; ?>

        <?= $form->field($model, 'rememberMe')->checkbox([1 => 'Запомнить меня']) ?>

        <div class="form-group">
            <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>