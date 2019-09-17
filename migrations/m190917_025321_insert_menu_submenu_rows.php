<?php

use yii\db\Migration;

/**
 * Class m190917_025321_insert_menu_submenu_rows
 */
class m190917_025321_insert_menu_submenu_rows extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('menu', [
            'label' => 'Admin',
            'icon' => 'fa-gears',
            'url' => '/',
            'order' => 999
        ]);

        $this->insert('submenu', [
            'menu_id' => 1,
            'label' => 'Menu',
            'icon' => 'fa-sitemap',
            'url' => '/menu/index',
            'order' => 1
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190917_025321_insert_menu_submenu_rows cannot be reverted.\n";
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190917_025321_insert_menu_submenu_rows cannot be reverted.\n";

        return false;
    }
    */
}
