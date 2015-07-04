<?php

namespace modules\users\models\frontend;

use common\behaviors\FileUploader;
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
     * Повторяем пароль
     * @var string
     */
    public $password_repeat;

    /**
     * Старый пароль
     * @var string
     */
    public $password_old;

    /**
     * Новый пароль
     * @var string
     */
    public $password_new;

    public function behaviors()
    {
        return [
            'FileUpload' => [
                'class' => FileUploader::className(),
                'attribute' => 'avatar',
                'attributeField' => 'avatar',
                'path' => '@files/users/avatars/',
                'urlPath' => '@urlFiles/users/avatars/',
                'name' => uniqid(),
                'extension' => 'jpg'
            ]
        ];
    }

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
            ['captcha', 'captcha', 'captchaAction' => 'users/guest/captcha',
                'on' => self::SCENARIO_REGISTRATION],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают',
                'on' => self::SCENARIO_REGISTRATION],
            ['login', 'unique', 'targetAttribute' => 'login', 'message' => 'Такой логин уже занят'],
            ['sex', 'in', 'range' => ['m', 'w'], 'message' => 'Укажите Ваш пол.'],
            ['avatar', 'file', 'mimeTypes' => ['image/png', 'image/gif', 'image/jpeg']],
            ['password_old', 'isOldPassword', 'on' => self::SCENARIO_PROFILE],
            ['password_new', 'string', 'min' => 6, 'max' => 64, 'tooShort' => 'Минимальная длина пароля 6 символов.',
                'tooLong' => 'Максимальная длина пароля 50 символов.', 'on' => self::SCENARIO_PROFILE,
            ],
            ['password_repeat', 'compare', 'compareAttribute' => 'password_new',
                'skipOnEmpty' => false, 'message' => 'Пароли не совпадают',
                'on' => self::SCENARIO_PROFILE,
                'when' => function ($model) {
                    return empty($model->password_new) === false;
                }
            ]
        ];
    }

    /**
     * Проверяем старый пароль
     * @param $attribute
     * @param $params
     */
    public function isOldPassword($attribute, $params)
    {
        if (!Yii::$app->security->validatePassword($this->{$attribute}, Yii::$app->user->identity->password)) {
            $this->addError($attribute, 'Неверный старый пароль');
        }
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
        } elseif ($this->password_new && $this->password_old) {
            $this->password = Yii::$app->security->generatePasswordHash($this->password_new);
        }

        $this->login = Html::encode($this->login);
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($this->scenario == self::SCENARIO_REGISTRATION) {
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
            'avatar' => 'Аватар',
            'captcha' => 'Код с картинки',
            'password_repeat' => 'Повторите пароль',
            'password_old' => 'Старый пароль',
            'password_new' => 'Новый пароль',
        ];
    }
}