<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%submenu}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%menu}}`
 */
class m190911_235333_create_submenu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%submenu}}', [
            'id' => $this->primaryKey(),
            'menu_id' => $this->integer()->notNull(),
            'label' => $this->string(100)->notNull()->defaultValue(''),
            'icon' => $this->string(100),
            'url' => $this->string(255)->defaultValue('/'),
            'order' => $this->integer()->defaultValue(999),
        ]);

        // creates index for column `menu_id`
        $this->createIndex(
            '{{%idx-submenu-menu_id}}',
            '{{%submenu}}',
            'menu_id'
        );

        // add foreign key for table `{{%menu}}`
        $this->addForeignKey(
            '{{%fk-submenu-menu_id}}',
            '{{%submenu}}',
            'menu_id',
            '{{%menu}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%menu}}`
        $this->dropForeignKey(
            '{{%fk-submenu-menu_id}}',
            '{{%submenu}}'
        );

        // drops index for column `menu_id`
        $this->dropIndex(
            '{{%idx-submenu-menu_id}}',
            '{{%submenu}}'
        );

        $this->dropTable('{{%submenu}}');
    }
}
