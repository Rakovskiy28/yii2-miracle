<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model frontend\models\Users */

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1 class="page-header"><?= Html::encode($this->title) ?></h1>

<div class="row">
    <div class="col-lg-4">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'login') ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
            'captchaAction' => 'index/captcha',
            'template' => '<div class="form-group input-group">{input}<span class="input-group-addon">{image}</span></div>',
        ]) ?>

        <?= $form->field($model, 'sex')->radioList(['m' => 'Мужской', 'w' => 'Женский']) ?>

        <div class="form-group">
            <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>