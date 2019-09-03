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
} else {
    AppAsset::register($this);
}
$this->registerJsFile('@web/js/loading.js', ['depends' => [yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/js/overrideConfirm.js', ['depends' => [\yii2mod\alert\AlertAsset::classname()]]);

$this->registerCssFile('@web/css/loading.css');
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

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            ['label' => 'SignUp', 'url' => ['/site/signup']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>
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

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
