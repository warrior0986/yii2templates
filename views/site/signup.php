<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Registrarse';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="card">
        <div class="card-header">
           <h4 class="title">Registrarse</h4>
        </div>
        <div class="card-content">

            <?php $form = ActiveForm::begin(['enableClientValidation' => true, 'id' => 'registrar']); ?>
            <div class="row">
                <?= $form->field($model, 'username', ['options'=>['class'=>'col-xs-12 label-floating']])->textInput()?>
                <?= $form->field($model, 'email', ['options'=>['class'=>'col-xs-12 label-floating']])->textInput()?>
                <?= $form->field($model, 'password', ['options'=>['class'=>'col-xs-12 label-floating']])->passwordInput()?>
                
            </div>
            <div>
                <?= Html::submitButton('Registrarse', ['class' => 'btn btn-primary pull-right']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>