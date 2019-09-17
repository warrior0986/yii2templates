<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SubmenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Submenus';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="submenu-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Submenu', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'menu_id',
            'label',
            [
                'value' => function($model, $key, $index, $widget) {
                    return '<i class="fa ' . $model->icon . '"><i> ' . $model->icon;
                },
                'format' => 'raw',
                'header' => 'icon'
            ],
            'url:url',
            //'order',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
