<?php

namespace modules\users\models\frontend;

use modules\users\models\NotSupportedException;
use Yii;
use common\helpers\Time;
use yii\helpers\Html;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use abeautifulsite\SimpleImage;

/**
 * Class Users
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

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
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
     * Полный путь к аватарке
     * @param bool $small Уменьшиная копия
     * @param bool $exists Делать проверку на наличие файла или нет
     * @return string
     */
    public function getPathAvatar($small = false, $exists = true)
    {
        $path = Yii::getAlias(Yii::$app->controller->module->filePath) .
            ($small ? 'small_' : '') .
            ($this->avatar ? $this->avatar : $this->oldAttributes['avatar']);
        return is_file($path) || $exists === false ? $path : null;
    }

    /**
     * URL к аватарке
     * @param bool $small Уменьшиная копия
     * @return string
     */
    public function getUrlAvatar($small = false)
    {
        if (is_file($this->getPathAvatar($small))){
            return Yii::getAlias(Yii::$app->controller->module->fileUrl) . ($small ? 'small_' : '') . $this->avatar;
        }
        return null;
    }

    /**
     * Удаление аватара
     */
    public function deleteAvatar($save = false)
    {
        if (is_file($this->getPathAvatar())){
            unlink($this->getPathAvatar());
        }
        if (is_file($this->getPathAvatar(true))){
            unlink($this->getPathAvatar(true));
        }
        $this->avatar = null;
        if ($save){
            $this->save(0);
        }
    }

    /**
     * Загружаем аватар
     * @throws \Exception
     */
    private function uploadAvatar()
    {
        $avatar = UploadedFile::getInstance($this, 'avatar');
        if ($avatar !== null){
            $this->deleteAvatar();
            $this->avatar = uniqid() . '.jpg';
            if ($avatar->saveAs($this->getPathAvatar(false, false))){
                $small = new SimpleImage($this->getPathAvatar());
                $small->thumbnail(120, 150);
                $small->save($this->getPathAvatar(true, false), 100, $avatar->extension);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($this->scenario == self::SCENARIO_PROFILE){
            $this->uploadAvatar();
        }
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