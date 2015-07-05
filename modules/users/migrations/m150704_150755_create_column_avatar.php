<?php

use yii\db\Schema;
use yii\db\Migration;

class m150704_150755_create_column_avatar extends Migration
{
    public function up()
    {
        $this->addColumn('{{%users}}', 'avatar', Schema::TYPE_STRING);
    }

    public function down()
    {
        $this->dropColumn('{{%users}}', 'avatar');
        return true;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
