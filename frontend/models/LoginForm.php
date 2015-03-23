<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\web\User;

class LoginForm extends Model
{
    public $login;
    public $password;
    public $rememberMe = true;
    private $_user;

    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            [['login', 'password'], 'userValidate']
        ];
    }

    public function userValidate()
    {
        $this->_user = Users::find()->where('login=LOWER(:login)', [':login' => $this->login])->one();

        if ($this->_user === null) {
            $this->addError('login', 'Пользователь не найден');
        } elseif (!Yii::$app->security->validatePassword($this->password, $this->_user->password)) {
            $this->addError('password', 'Неверный пароль');
        }
    }

    public function login()
    {
        if ($this->validate()) {
            if (Yii::$app->user->login($this->_user, $this->rememberMe ? 864000 : 0)) {
                return true;
            } else {
                $this->addError('login', 'Ошибка авторизции. Попробуйте ещё');
            }
        }
        return false;
    }

    public function attributeLabels()
    {
        return [
            'login' => 'Логин',
            'password' => 'Пароль',
            'verifyCode' => 'Код с картинки',
            'rememberMe' => 'Запомнить меня'
        ];
    }

}
