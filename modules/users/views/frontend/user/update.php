<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \modules\users\models\frontend\Users */
/* @var $form yii\widgets\ActiveForm */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Личные данные';
$this->params['pageTitle'] = $this->title;
$this->params['breadcrumbs'][] = ['label' => $model->login, 'url' => ['/users/default/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row col-lg-5">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data'
        ]
    ]); ?>

    <div class="form-group">
        <?php if ($model->fileUrl !== null): ?>
            <img src="<?= $model->fileUrl ?>" alt="<?= $model->login ?>"/>
        <?php endif; ?>
        <?= $form->field($model, 'avatar')->fileInput() ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'password_old')->passwordInput(['maxlength' => 64]) ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'password_new')->passwordInput(['maxlength' => 64]) ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => 64]) ?>
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