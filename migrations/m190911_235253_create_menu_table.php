<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%menu}}`.
 */
class m190911_235253_create_menu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%menu}}', [
            'id' => $this->primaryKey(),
            'label' => $this->string(100)->notNull()->defaultValue(''),
            'icon' => $this->string(100),
            'url' => $this->string(255)->defaultValue('/'),
            'order' => $this->integer()->defaultValue(999),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%menu}}');
    }
}
