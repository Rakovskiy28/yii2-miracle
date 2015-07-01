<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $model \modules\users\models\frontend\Users */

$this->title = 'Регистрация';
$this->params['pageTitle'] = $this->title;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row col-lg-5">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= $form->field($model, 'login')->textInput(['maxlength' => 50]) ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => 64]) ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => 64]) ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'captcha')->widget(Captcha::className(), [
            'captchaAction' => '/users/guest/captcha',
            'template' => '<div class="form-group input-group">{input}<span class="input-group-addon">{image}</span></div>',
        ]) ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'sex')->dropDownList([
            'm' => 'Мужской',
            'w' => 'Женский',
        ]); ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>