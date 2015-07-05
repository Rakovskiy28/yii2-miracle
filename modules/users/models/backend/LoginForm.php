<?php

namespace modules\users\models\backend;

use modules\users\models\backend\Users;
use Yii;
use yii\base\Model;
use yii\captcha\CaptchaValidator;
use yii\helpers\VarDumper;
use yii\validators\Validator;
use yii\web\User;

/**
 * Class LoginForm
 * @package modules\users\models\backend
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
     * Логин
     * @var string
     */
    public $login;
    /**
     * Пароль
     * @var string
     */
    public $password;
    /**
     * Запомнить меня
     * @var bool
     */
    public $rememberMe = true;
    /**
     * Капча
     * @var string
     */
    public $verifyCode;
    /**
     * Храним данные пользователя
     * @var object
     */
    public $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            [['login', 'password'], 'userValidate'],
            ['verifyCode', 'required', 'when' => function ($model) {
                return isset($model->_user->error_auth) && $model->_user->error_auth > 3;
            }
            ],
            ['verifyCode', 'captchaValidate', 'skipOnEmpty' => false, 'when' => function ($model) {
                return isset($model->_user->error_auth) && $model->_user->error_auth > 3;
            }
            ],
        ];
    }

    /**
     * Проверяем капчу и обновляем счётчик ошибок авторизации
     * @param $attribute string
     * @param $params array
     */
    public function captchaValidate($attribute, $params)
    {
        $validator = Validator::createValidator('captcha', $this, $attribute, [
            'captchaAction' => 'users/guest/captcha'
        ]);

        if ($validator->validate($this->verifyCode) === false) {
            $this->addError($attribute, 'Неверный код с картинки');
        } else {
            $this->_user->error_auth = 0;
            $this->_user->save(0);
        }
    }

    /**
     * Ищем пользователя по логину и паролю
     * @throws \yii\base\InvalidConfigException
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
        } elseif (isset($auth->getPermissionsByUser($this->_user->id)['backend_access']) === false){
            $this->addError('login', 'Недостаточно прав');
        }
    }

    /**
     * Авторизуем пользователя
     * @return bool
     */
    public function login()
    {
        if ($this->validate()) {
            if (Yii::$app->user->login($this->_user, $this->rememberMe ? 864000 : 0)) {
                return true;
            } else {
                $this->addError('login', 'Ошибка авторизации. Попробуйте ещё');
            }
        }
        return false;
    }

    /**
     * @inheritdoc
     */
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
