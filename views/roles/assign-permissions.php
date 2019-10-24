<?php

use yii\helpers\Html;
use kartik\select2\Select2;

$this->title = 'Assigns Permissions to: ' . $role;
?>
<div class="card">
	<div class="card-header">
    	<h4 class="title"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="card-content">
        <?= Html::beginForm([
            '/roles/assign-permissions',
            'role' => $role
            ], 'POST'); ?>
            <?php
                echo Select2::widget([
                    'name' => 'permissions',
                    'value' => $dropDownDataAssigned,
                    'data' => $dropDownData,
                    'options' => ['multiple' => true, 'placeholder' => 'Select permissions']
                ]);
            ?>
            <div>
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']); ?>
            </div>
        <?= Html::endForm(); ?>
	    
    </div>

</div>
