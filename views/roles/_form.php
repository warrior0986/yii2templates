<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>

<div class="role-form">

    <?php $form = ActiveForm::begin([
        // 'enableAjaxValidation' => true,
        'id' => 'roleCreate'
        ]); ?>

    <!-- TODO: add the hide field menu_id -->
    <div class="row">
        <?= $form->field($model, 'name')->textInput(); ?>
        <?= $form->field($model, 'description')->textArea(); ?>
        <?= $form->field($model, 'oldName')->hiddenInput()->label(false); ?>
        
    </div>

    <div>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
