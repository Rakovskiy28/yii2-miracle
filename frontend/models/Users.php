<?php

namespace frontend\models;

use common\helpers\Time;
use yii\helpers\Html;
use \yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Users extends ActiveRecord implements IdentityInterface
{
    public $verifyCode;
    public $sex = 'm';

    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['login', 'password'], 'required', 'on' => 'reg'],
            ['login', 'string', 'min' => 3, 'max' => 25, 'tooShort' => 'Минимальная длина логина 3 сим.', 'tooLong' => 'Максимальная длина логина 25 сим.', 'on' => 'reg'],
            ['password', 'string', 'min' => 6, 'max' => 50, 'tooShort' => 'Минимальная длина пароля 6 сим.', 'tooLong' => 'Максимальная длина пароля 50 сим.', 'on' => 'reg'],
            ['login', 'unique', 'targetAttribute' => 'login', 'message' => 'Такой логин уже занят', 'on' => 'reg'],
            ['sex', 'in', 'range' => ['m', 'w'], 'on' => 'reg'],
            ['verifyCode', 'captcha', 'captchaAction' => 'index/captcha', 'on' => 'reg']
        ];
    }

    public function attributeLabels()
    {
        return [
            'login' => 'Логин',
            'password' => 'Пароль',
            'sex' => 'Ваш пол',
            'verifyCode' => 'Код с картинки'
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('findIdentityByAccessToken is not implemented.');
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->time_reg = Time::real();
            $this->time_visit = Time::real();
            $this->time_total = 0;
        }

        $this->login = Html::encode($this->login);
        $this->password = \Yii::$app->security->generatePasswordHash($this->password);
        return parent::beforeSave($insert);
    }
}