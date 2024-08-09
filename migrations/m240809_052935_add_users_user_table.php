<?php

use yii\db\Migration;

/**
 * Class m240809_052935_add_users_user_table
 */
class m240809_052935_add_users_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('user', ['username', 'password', 'auth_key', 'access_token'], [
            ['user1', 'password1', 'authKey1', 'accessToken1'],
            ['user2', 'password2', 'authKey2', 'accessToken2'],
            ['user3', 'password3', 'authKey3', 'accessToken3'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('user', ['in', 'username', ['user1', 'user2', 'user3',]]);

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240809_052935_add_users_user_table cannot be reverted.\n";

        return false;
    }
    */
}
