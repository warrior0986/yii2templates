<?php

use yii\helpers\Html;
use kartik\select2\Select2;

$this->title = 'Assigns Users to: ' . $role->name;
?>
<div class="card">
	<div class="card-header">
    	<h4 class="title"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="card-content">
        <?= Html::beginForm([
            '/roles/assign-users',
            'role' => $role->name
            ], 'POST'); ?>
            <?php
                echo Select2::widget([
                    'name' => 'users',
                    'value' => $usersByRole,
                    'data' => $users,
                    'options' => ['multiple' => true, 'placeholder' => 'Select users']
                ]);
            ?>
            <div>
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']); ?>
            </div>
        <?= Html::endForm(); ?>
	    
    </div>

</div>
