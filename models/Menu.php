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
        return $this->hasMany(Submenu::className(), ['menu_id' => 'id']);
    }
}
