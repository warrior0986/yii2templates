<?php

namespace app\models;

class Role extends \yii\base\Model
{
    public $type;
    public $name;
    public $description;
    public $oldName;

    public function rules()
    {
        return [
            [['name', 'description', 'oldName'], 'string'],
            ['name', 'required']
        ];
    }
}