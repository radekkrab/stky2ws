<?php

use yii\db\Migration;

/**
 * Class m240809_045203_connection_table
 */
class m240809_045203_connection_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'auth_key' => $this->string()->notNull(),
            'access_token' => $this->string()->notNull(),
        ]);

        $this->createTable('connection', [
            'id' => $this->primaryKey(),
            'token' => $this->string()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'user_agent' => $this->string()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'finished_at' => $this->timestamp()->null(),
        ]);

        $this->addForeignKey(
            'fk-connection-user_id',
            'connection',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-connection-user_id', 'connection');
        $this->dropTable('connection');
        $this->dropTable('user');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240809_045203_connection_table cannot be reverted.\n";

        return false;
    }
    */
}
