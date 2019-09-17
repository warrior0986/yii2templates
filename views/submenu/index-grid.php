<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SubmenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Submenus';
$this->params['breadcrumbs'][] = $this->title;
$menu_id = Yii::$app->request->post('expandRowKey');
?>
<div class="submenu-index">
    <p>
        <?= Html::button('Create Submenu', ['value' => Url::to(['create', 'menuId' => $menu_id]), 'title' => 'Creating New Submenu', 'class' => 'showModalButton btn btn-success']); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'menu_id',
            'label',
            [
                'value' => function($model, $key, $index, $widget) {
                    return '<i class="fa ' . $model->icon . '"><i> ' . $model->icon;
                },
                'format' => 'raw',
                'header' => 'icon'
            ],
            'url:url',
            'order',

            // ['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'kartik\grid\ActionColumn',
                // 'header'=> 'Acciones',
                // 'headerOptions'=> ['style'=>'text-align:center'],
                // 'contentOptions'=> ['style'=>'text-align:center'],
                'template'=>'{update} {delete}',
                // 'options' =>['width'=> '100px'],
                // 'hiddenFromExport'=> true,
                 'buttons'=>[
                            'update'=> function($url, $model)
                            {
                                return Html::a('<span class = "glyphicon glyphicon-pencil"></span>', "#", ['title' => 'Updating Submenu', 'class' => 'showModalButton', 'value' => Url::to(['update', 'id' => $model->id])]);
                                   
                            },
                 ]
                //             'delete'=> function($url, $model)
                //             {
                //                 return Html::a('<span class = "fa fa-camera-retro "> </span>', Yii::$app->request->baseUrl.'/auditoria/gestionar-auditoriadocumento?uidAuditoria='.$model['uid']."&activo=0", ['title' => 'Gestionar Auditoria']);
                                   
                //             }
                //     ],
            ]
        ],
    ]); ?>


</div>
