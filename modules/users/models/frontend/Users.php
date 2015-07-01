<?php

namespace modules\users\models\frontend;

use modules\users\models\NotSupportedException;
use Yii;
use common\helpers\Time;
use yii\helpers\Html;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Class Users
 * @package modules\users\models
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
 */
class Users extends ActiveRecord implements IdentityInterface
{
    const SCENARIO_PROFILE = 'profile';
    const SCENARIO_REGISTRATION = 'registration';

    /**
     * Код с картинки
     * @var string
     */
    public $captcha;

    /**
     * Повторяем новый пароль
     * @var string
     */
    public $password_repeat;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sex = empty($this->sex) ? 'm' : $this->sex;
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['login', 'password', 'captcha'], 'required',
                'on' => self::SCENARIO_REGISTRATION],
            ['login', 'string', 'min' => 3, 'max' => 50, 'tooShort' => 'Минимальная длина логина 3 символа.',
                'tooLong' => 'Максимальная длина логина 25 символа.',
                'on' => self::SCENARIO_REGISTRATION],
            ['password', 'string', 'min' => 6, 'max' => 64, 'tooShort' => 'Минимальная длина пароля 6 символов.',
                'tooLong' => 'Максимальная длина пароля 64 символа.',
                'on' => self::SCENARIO_REGISTRATION],
            ['sex', 'in', 'range' => ['m', 'w'], 'message' => 'Укажите Ваш пол.',
                'on' => self::SCENARIO_REGISTRATION],
            ['captcha', 'captcha', 'captchaAction' => 'users/guest/captcha',
                'on' => self::SCENARIO_REGISTRATION],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают',
                'on' => self::SCENARIO_REGISTRATION],
            ['login', 'unique', 'targetAttribute' => 'login', 'message' => 'Такой логин уже занят']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('findIdentityByAccessToken is not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return parent::scenarios();
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
            $this->time_reg = Time::real();
            $this->time_login = Time::real();
            $this->ip = Yii::$app->request->getUserIP();
            $this->ua = Yii::$app->request->getUserAgent();
        }

        $this->login = Html::encode($this->login);
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($this->scenario == self::SCENARIO_REGISTRATION){
            Yii::$app->user->login($this);
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'password' => 'Пароль',
            'sex' => 'Пол',
            'time_reg' => 'Дата регистрации',
            'time_login' => 'Последняя авторизация',
            'ip' => 'IP адрес',
            'ua' => 'User Agent',
            'captcha' => 'Код с картинки',
            'password_repeat' => 'Повторите пароль',
        ];
    }
}