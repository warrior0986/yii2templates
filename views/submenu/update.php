<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Submenu */

$this->title = 'Update Submenu: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Submenus', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="card">
	<div class="card-header">
    	<h4 class="title"><?= Html::encode($this->title) ?></h4>
    	<!-- <p class="category">Danos información de dónde, cuando y a que hora se perdió</p> -->
    </div>
    <div class="card-content">
	    <?= $this->render('_form', [
	        'model' => $model,
	    ]) ?>
    </div>

</div>
