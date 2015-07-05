<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modules\rbac\models\RolesForm;

/* @var $this yii\web\View */
/* @var $model \modules\rbac\models\RolesForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<div class="row col-lg-5">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= $form->field($model, 'alias')->textInput(
            [
                'maxlength' => 50,
                'disabled' => $model->scenario === $model::SCENARIO_UPDATE ? true : false
            ]) ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'name')->textInput(['maxlength' => 50]) ?>
    </div>

    <?php if (($rules = RolesForm::getRules()) != null): ?>
        <div class="form-group">
            <?= $form->field($model, 'rule')->dropDownList($rules) ?>
        </div>
    <?php endif; ?>

    <?php if (($permissions = RolesForm::getPermissions()) != null): ?>
        <div class="form-group">
            <?= $form->field($model, 'permissions')->checkboxList($permissions, [
                'item' => function ($index, $label, $name, $checked, $value) {
                    $checked = RolesForm::isChild(Yii::$app->request->get('id'), $value);
                    $checkbox = Html::checkbox($name, $checked, [
                        'label' => $label,
                        'value' => $value,
                    ]);
                    return Html::tag('div', $checkbox, [
                        'class' => 'checkbox'
                    ]);
                }
            ]) ?>
        </div>
    <?php endif; ?>

    <?php if (($roles = RolesForm::getRoles(Yii::$app->request->get('id'))) != null): ?>
        <div class="form-group">
            <?= $form->field($model, 'child_roles')->checkboxList($roles, [
                'item' => function ($index, $label, $name, $checked, $value) {
                    $checked = RolesForm::isChild(Yii::$app->request->get('id'), $value);
                    $checkbox = Html::checkbox($name, $checked, [
                        'label' => $label,
                        'value' => $value,
                    ]);
                    return Html::tag('div', $checkbox, [
                        'class' => 'checkbox'
                    ]);
                }
            ]) ?>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>