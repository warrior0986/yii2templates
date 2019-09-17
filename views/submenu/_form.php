<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dominus77\iconpicker\IconPicker;

/* @var $this yii\web\View */
/* @var $model app\models\Submenu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="submenu-form">

    <?php $form = ActiveForm::begin([
        // 'enableAjaxValidation' => true,
        'id' => 'subMenuCreate'
        ]); ?>

    <!-- TODO: add the hide field menu_id -->
    <div class="row">
        <?= $form->field($model, 'menu_id')->hiddenInput()->label(false); ?>

        <?= $form->field($model, 'label', ['options'=>['class'=>'col-sm-3 col-xs-12']])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'icon', ['options'=>['class'=>'col-sm-3 col-xs-12']])->widget(IconPicker::className(), [
            'clientOptions' => [
                'hideOnSelect' => true
            ]
        ]); ?>

        <?= $form->field($model, 'url', ['options'=>['class'=>'col-sm-3 col-xs-12']])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'order', ['options'=>['class'=>'col-sm-3 col-xs-12']])->textInput() ?>
    </div>

    <div>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
