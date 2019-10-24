<?php

use yii\db\Migration;

/**
 * Class m191009_020850_add_role_submenu
 */
class m191009_020850_add_role_submenu extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $this->insert('submenu', [
            'menu_id' => 1,
            'label' => 'Roles',
            'icon' => 'fa-group',
            'url' => '/roles/index',
            'order' => 2
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191009_020850_add_role_submenu cannot be reverted.\n";

        return false;
    }
    */
}
