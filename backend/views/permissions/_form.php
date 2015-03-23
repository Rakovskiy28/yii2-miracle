<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\RolesForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PermissionsForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<div class="row col-lg-5">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= $form->field($model, 'rule')->textInput(['maxlength' => 50]) ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'name')->textInput(['maxlength' => 50]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>