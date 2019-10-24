<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "submenu".
 *
 * @property int $id
 * @property int $menu_id
 * @property string $label
 * @property string $icon
 * @property string $url
 * @property int $order
 *
 * @property Menu $menu
 */
class Submenu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'submenu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['menu_id'], 'required'],
            [['label'], 'required'],
            [['menu_id', 'order'], 'integer'],
            [['label', 'icon'], 'string', 'max' => 100],
            [['url'], 'string', 'max' => 255],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['menu_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_id' => 'Menu ID',
            'label' => 'Label',
            'icon' => 'Icon',
            'url' => 'Url',
            'order' => 'Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }
}
