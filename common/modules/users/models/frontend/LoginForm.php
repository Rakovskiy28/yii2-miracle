<?php

namespace modules\users\models\frontend;

use modules\users\models\frontend\Users;
use Yii;
use modules\users\models\backend\LoginForm as Model;
use yii\validators\Validator;

/**
 * Class LoginForm
 * @package modules\users\models\frontend
 *
 * @property string $id
 * @property string $login
 * @property string $password
 * @property string $auth_key
 * @property string $time_reg
 * @property string $time_login
 * @property string $ip
 * @property string $ua
 * @property string $role
 * @property string $sex
 * @property string $error_auth
 * @property string $avatar
 */
class LoginForm extends Model
{
    /**
     * @inheritdoc
     */
    public function userValidate()
    {
        $auth = Yii::$app->authManager;
        $this->_user = Users::find()->where('login=LOWER(:login)', [':login' => $this->login])->one();

        if ($this->_user === null) {
            $this->addError('login', 'Пользователь не найден');
        } elseif (!Yii::$app->security->validatePassword($this->password, $this->_user->password)) {
            $this->_user->error_auth++;
            $this->_user->save();
            $this->password = null;
            $this->addError('password', 'Неверный пароль');
        }
    }
}
