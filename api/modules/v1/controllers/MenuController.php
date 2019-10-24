<?php
namespace app\api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use app\models\Menu;

class MenuController extends ActiveController
{
    // We are using the regular web app modules:
    public $modelClass = 'app\models\Menu';

    public function actions(){
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex() {
        $userId = Yii::$app->getRequest()->getQueryParam('userId') ? Yii::$app->getRequest()->getQueryParam('userId') : null;
        $menuOptions = Menu::getMenuOptionsByUserId($userId);
        return $menuOptions;
    }
}