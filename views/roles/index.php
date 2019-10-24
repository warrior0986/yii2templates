<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SubmenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Roles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="roles-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Role', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $rolesDataProvider,
        'columns' => [
            'name',
            'description',
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update} {delete} {assignPermissions} {assignUsers}',
                // 'options' =>['width'=> '100px'],
                // 'hiddenFromExport'=> true,
                 'buttons'=>[
                            'assignPermissions'=> function($url, $model)
                            {
                                return Html::a('<span class = "fa fa-address-card "> </span>', Yii::$app->request->baseUrl.'/roles/assign-permissions?role='.$model->name, ['title' => 'Assign Permissions']);
                                   
                            },
                            'assignUsers'=> function($url, $model)
                            {
                                return Html::a('<span class = "fa fa-users "> </span>', Yii::$app->request->baseUrl.'/roles/assign-users?role='.$model->name, ['title' => 'Assign Users']);
                                   
                            },
                 ]
            ],
        ],
    ]); ?>


</div>
