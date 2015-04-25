<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Users;

/* @var $this yii\web\View */
/* @var $model backend\models\Users */
/* @var $form yii\widgets\ActiveForm */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<div class="row col-lg-5">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= $form->field($model, 'login')->textInput(['maxlength' => 50]) ?>
    </div>
у
    <?php if ($model->id === Yii::$app->user->getId()): ?>
        <div class="form-group">
            <?= $form->field($model, 'old_password')->passwordInput(['maxlength' => 50]) ?>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <?= $form->field($model, $model->isNewRecord ? 'password' : 'new_password')->passwordInput(['maxlength' => 50]) ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'new_password_repeat')->passwordInput(['maxlength' => 50]) ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'sex')->dropDownList([
            'm' => 'Мужской',
            'w' => 'Женский',
        ]); ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'role')->dropDownList($model->getRoles()); ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>