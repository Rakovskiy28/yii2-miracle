<?php

use yii\db\Schema;
use yii\db\Migration;
use modules\users\models\Users;
use common\helpers\Time;

class m150515_130844_create_table_users extends Migration
{
    public function up()
    {
        $this->createTable('{{%users}}', [
            'id' => Schema::TYPE_PK,
            'login' => Schema::TYPE_TEXT . '(50) NOT NULL',
            'password' => Schema::TYPE_TEXT . '(64) NOT NULL',
            'auth_key' => Schema::TYPE_TEXT . '(100)',
            'time_reg' => Schema::TYPE_INTEGER,
            'time_login' => Schema::TYPE_INTEGER,
            'ip' => Schema::TYPE_TEXT . '(50)',
            'ua' => Schema::TYPE_TEXT . '(100)',
            'role' => Schema::TYPE_TEXT . '(50)',
            'sex' => Schema::TYPE_TEXT . '(1)',
            'error_auth' => Schema::TYPE_INTEGER,
        ]);

        $this->execute($this->createAdmin());
    }

    public function down()
    {
        $this->dropTable('{{%users}}');
        return false;
    }

    public function createAdmin()
    {
        $time = Time::real();
        $password = Yii::$app->security->generatePasswordHash('admin');

        return "INSERT INTO {{%users}} SET
          `login` = 'Admin',
          `password` = '$password',
          `time_reg` = '$time',
          `time_login` = '$time',
          `role` = 'admin',
          `sex` = 'm'";
    }
}
