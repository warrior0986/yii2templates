<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

if (class_exists('ramosisw\CImaterial\web\MaterialAsset')) {
    ramosisw\CImaterial\web\MaterialAsset::register($this);
} 
AppAsset::register($this);
// $this->registerJsFile('@web/js/loading.js', ['depends' => [yii\web\JqueryAsset::className()]]);
// $this->registerJsFile('@web/js/ajax-modal-popup.js', ['depends' => [yii\web\JqueryAsset::className()]]);
// $this->registerJsFile('@web/js/overrideConfirm.js', ['depends' => [\yii2mod\alert\AlertAsset::classname()]]);

// $this->registerCssFile('@web/css/loading.css');

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/ramosisw/yii2-material-dashboard/assets');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrapper">
    <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
    ?>
    <div class="main-panel ps-active-y" style="padding-left:15px;">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'options' => [
            'class' => 'navbar-transparent',
            // 'style' => 'display:none'
        ],
        'renderInnerContainer' => false,
        'containerOptions' => ['class' => 'container-fluid']
    ]);
    NavBar::end();
    ?>
        <!-- <div class="container"> -->
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>

            <?= $content ?>
            <footer class="footer">
                <div class="container-fluid">
                    <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

                    <p class="pull-right"><?= Yii::powered() ?></p>
                </div>
            </footer>
        <!-- </div> -->
    </div>
</div>
<!--Loading-->
<div id="loading">
    <img src="<?= Url::to('@web/loading.gif') ?>" alt="Loading"/>
</div>
<!--Notificaciones-->
<?php foreach (Yii::$app->session->getAllFlashes() as $message):;  ?>
    <?php 
    echo \yii2mod\alert\Alert::widget([
        'useSessionFlash' => false,
        'options' =>[
            'type' => (!empty($message['type'])) ? $message['type'] : 'error',
            'timer' => (isset($message['timer'])) ? $message['timer'] : 2500,
            'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
            'text' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
            'showConfirmButton' => false,
        ],
        'callback' => '' //Para que funcione el timer ya que el callback por defecto se concatena al final del js, evitando que se ejecute bien el timer
    ]);
    ?>
<?php endforeach; ?>
<!-- Modal -->
<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    // 'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
]);
echo "<div id='modalContent'><div class='col-lg'>
<img src='" . Url::to('@web/loading.gif') . "'>
</div></div>";
yii\bootstrap\Modal::end();
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
