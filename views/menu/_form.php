<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dominus77\iconpicker\IconPicker;

/* @var $this yii\web\View */
/* @var $model app\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'label', ['options'=>['class'=>'col-sm-3 col-xs-12']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'icon', ['options'=>['class'=>'col-sm-3 col-xs-12']])->widget(IconPicker::className(), [
        'clientOptions' => [
            'hideOnSelect' => true
        ]
    ]); ?>

    <?= $form->field($model, 'url', ['options'=>['class'=>'col-sm-3 col-xs-12']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order', ['options'=>['class'=>'col-sm-3 col-xs-12']])->textInput() ?>

    <div>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
