<?php 
// use app\models\Menu;
?>
<div class="sidebar" data-color = 'purple'>
        <!-- Sidebar user panel -->
        <div class="logo">
            Test Template
        </div>
        <div class="sidebar-wrapper ps-container">
            <?= ramosisw\CImaterial\widgets\Menu::widget(
            // dmstr\widgets\Menu::widget(
                [
                    'options' => ['class' => 'nav'],
                    'items' => [
                        ['label' => 'Home', 'url' => ['site/index'], 'icon' => 'home'],
                        ['label' => 'About', 'url' => ['/site/about'], 'icon' => 'info'],
                        ['label' => 'Contact', 'url' => ['/site/contact'], 'icon' => 'phone'],
                        ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'account_box', 'visible' => Yii::$app->user->isGuest],
                        ['label' => 'Logout', 'url' => ['site/login'], 'icon' => 'arrow_back', 'visible' => !Yii::$app->user->isGuest],
                    ],
                ]
            ) ?>
        </div>
</div>
