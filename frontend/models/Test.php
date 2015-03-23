<?php

namespace app\models;

class Test extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'test';
    }

    public function getAuthor()
    {
        return $this->hasOne('app\models\Users', array('id' => 'user'));
    }
}