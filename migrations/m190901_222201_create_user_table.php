<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m190901_222201_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->notNull(),
            'auth_key' => $this->string(32),
            'password_hash' => $this->string(255)->notNull(),
            'password_reset_token' => $this->string(255),
            'verification_token' => $this->string(255),
            'email' => $this->string(255)->notNull(),
            'status' => $this->integer(),
            'created_at' => $this->timestamp()->null(),
            'updated_at' => $this->timestamp()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
