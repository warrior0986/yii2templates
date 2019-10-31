<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property string $label
 * @property string $icon
 * @property string $url
 * @property int $order
 *
 * @property Submenu[] $submenus
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return 'menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order'], 'integer'],
            [['label'], 'required'],
            [['label', 'icon'], 'string', 'max' => 100],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'label' => 'Label',
            'icon' => 'Icon',
            'url' => 'Url',
            'order' => 'Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubmenus()
    {
        return $this->hasMany(Submenu::className(), ['menu_id' => 'id'])->orderBy(['submenu.order' => SORT_ASC]);
    }

    public function getMenuOptions() {
        $menuOptions = self::getMenu();
        $menuOptionsArray = [];
        foreach ($menuOptions as $key => $menu) {
            if (!empty($menu->submenus)) {
                foreach ($menu->submenus as $key => $submenu) {
                    $menuOptionsArray['menuopt-' . strtolower($menu->label) . '-' . strtolower($submenu->label)] = 'menuopt-' . ucfirst($menu->label) . '-' . ucfirst($submenu->label);
                }
            } else {
                $menuOptionsArray['menuopt-' . strtolower($menu->label)] = 'menuopt-'. ucfirst($menu->label);
            }
        }
        return $menuOptionsArray;
    }

    public function getMenu() {
        return self::find()->joinWith('submenus')->orderBy([
            'menu.order' => SORT_ASC
        ])->all();
    }

    public static function getMenuOptionsByUserId($userId) {
        if (!is_null($userId)) {
            $auth = Yii::$app->authManager;
            $permissions = $auth->getPermissionsByUser($userId);
            $permissionsArray = array_keys($permissions);
            $menuOpts = [];
            $subMenuOpts = [];
            foreach ($permissionsArray as $key => $permission) {
                if (strpos('menuopt-', $permission) === false) {
                    $permissionExplode = explode('-', $permission);;
                    array_push($menuOpts, $permissionExplode[1]);
                    if (isset($permissionExplode[2])) {
                        array_push($subMenuOpts, $permissionExplode[2]);
                    }
                }
            }

            $menuOptions = (array) self::getMenu();
            $menuOptions2 = [];
            foreach ($menuOptions as $keyMenu => $menu) {
                $option = [];
                if (in_array(strtolower($menu->label),$menuOpts)) {
                    $option['id'] = $menu->id;
                    $option['label'] = $menu->label;
                    $option['icon'] = $menu->icon;
                    $option['url'] = $menu->url;
                    $option['order'] = $menu->order;
                
                    if (!empty($menu->submenus)) { 
                        $option['submenus'] = [];
                        foreach ($menu->submenus as $key => $submenu) {
                            $optionSubmenu = [];
                            if (in_array(strtolower($submenu->label),$subMenuOpts)) {
                                $optionSubmenu['id'] = $submenu->id;
                                $optionSubmenu['label'] = $submenu->label;
                                $optionSubmenu['icon'] = $submenu->icon;
                                $optionSubmenu['url'] = $submenu->url;
                                $optionSubmenu['order'] = $submenu->order;
                                array_push($option['submenus'], $optionSubmenu);
                            }
                        }
                    }
                    array_push($menuOptions2, $option);
                }
            }

            return $menuOptions2;
        } else {
            return [];
        }
    }
}
