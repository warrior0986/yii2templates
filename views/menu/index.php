<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menus';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Menu', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                // uncomment below and comment detail if you need to render via ajax
                'detailUrl'=> Url::to(['/submenu/index-grid']),
                // 'detail' => function ($model, $key, $index, $column) {
                //     return Yii::$app->controller->renderPartial('/submenu/index-grid', ['menu' => $model]);
                // },
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'expandOneOnly' => true
            ],
            'label',
            // 'icon',
            [
                'value' => function($model, $key, $index, $widget) {
                    return '<i class="fa ' . $model->icon . '"><i> ' . $model->icon;
                },
                'format' => 'raw',
                'header' => 'icon'
            ],
            'url:url',
            'order',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
