<?php 
use app\models\Menu;
use yii\helpers\Url;
$staticOptions = [
    ['label' => 'Home', 'url' => ['site/index'], 'icon' => '<i class="fa fa-500px"></i>'],
    ['label' => 'About', 'url' => ['/site/about'], 'icon' => 'info'],
    ['label' => 'Contact', 'url' => ['/site/contact'], 'icon' => 'phone'],
    ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'account_box', 'visible' => Yii::$app->user->isGuest],
    ['label' => 'Logout', 'url' => ['site/login'], 'icon' => 'arrow_back', 'visible' => !Yii::$app->user->isGuest],
];

// $menuBD = Menu::getMenu(); // if you want to render the menu without user role base uncomment this
$userId = isset(Yii::$app->user->identity) ? Yii::$app->user->identity->id : null;
$menuBD = Menu::getMenuOptionsByUserId($userId);
$menuArray = [];
foreach ($menuBD as $menuOptionBD) {
    $menuOption = [];
    $menuOption['label'] = isset($menuOptionBD['label']) ? $menuOptionBD['label'] : 'No Label';
    $menuOption['url'] = isset($menuOptionBD['url']) ? [$menuOptionBD['url']] : 'No url';
    $menuOption['icon'] = isset($menuOptionBD['icon']) ? '<i class="fa ' . $menuOptionBD['icon'] . '"></i>' : 'No icon';

    if (isset($menuOptionBD['submenus'])) {
        $counter = 0;
        foreach ($menuOptionBD['submenus'] as $submenu) {
            $menuOption['items'][$counter]['label'] = isset($submenu['label']) ? $submenu['label'] : 'No Label';
            $menuOption['items'][$counter]['url'] = isset($submenu['url']) ? [$submenu['url']] : 'No url';
            $menuOption['items'][$counter]['icon'] = isset($submenu['icon']) ? '<i class="fa ' . $submenu['icon'] . '"></i>': 'No icon';
            $counter++;
        }
    }

    array_push($menuArray, $menuOption);
}
if (!Yii::$app->user->isGuest) {
    array_push($menuArray, ['label' => 'Logout', 'url' => ['site/logout'], 'icon' => 'arrow_back']);
} else {
    array_push($menuArray, ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'account_box']);
}
?>
<div class="sidebar" data-color = 'purple'>
        <!-- Sidebar user panel -->
        <!-- <div class="simple-text logo-normal">
            Test Template
        </div> -->
        <div class="sidebar-wrapper ps-container">
            <?= ramosisw\CImaterial\widgets\Menu::widget(
            // dmstr\widgets\Menu::widget(
                [
                    'itemOptions' => ['class' => 'nav-item'],
                    'options' => ['class' => 'nav'],
                    'items' => $menuArray, // if you want the static option, jus change this variable
                ]
            ) ?>
        </div>
</div>
