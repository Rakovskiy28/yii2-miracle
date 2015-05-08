<?php

namespace modules\users\models;

use backend\models\NotSupportedException;
use yii;
use common\helpers\Time;
use yii\helpers\Html;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;

class Users extends ActiveRecord implements IdentityInterface
{
    const SCENARIO_PROFILE = 'profile';

    /**
     * Старый пароль
     * @var string
     */
    public $old_password;

    /**
     * Новый пароль
     * @var string
     */
    public $new_password;

    /**
     * Повторяем новый пароль
     * @var string
     */
    public $new_password_repeat;

    /**
     * Все роли
     * @var array
     */
    private static $roles = [];

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
            [['login'], 'required'],
            ['login', 'string', 'min' => 3, 'max' => 50, 'tooShort' => 'Минимальная длина логина 3 сим.', 'tooLong' => 'Максимальная длина логина 25 сим.',
                'when' => function ($model) {
                    return Yii::$app->user->can('users_crud');
                }
            ],
            ['login', 'unique', 'targetAttribute' => 'login', 'message' => 'Такой логин уже занят',
                'when' => function ($model) {
                    return Yii::$app->user->can('users_crud');
                }
            ],
            ['sex', 'in', 'range' => ['m', 'w'], 'message' => 'Укажите Ваш пол'],
            [['password'], 'required',
                'when' => function ($model) {
                    return $model->isNewRecord;
                }
            ],
            ['password', 'string', 'min' => 6, 'max' => 50, 'tooShort' => 'Минимальная длина пароля 6 сим.', 'tooLong' => 'Максимальная длина пароля 50 сим.',
                'when' => function ($model) {
                    return $model->isNewRecord;
                }
            ],
            ['old_password', 'isOldPassword', 'when' => function ($model) {
                return $this->id === Yii::$app->user->getId();
            }],
            ['new_password', 'string', 'min' => 6, 'max' => 50, 'tooShort' => 'Минимальная длина пароля 6 сим.', 'tooLong' => 'Максимальная длина пароля 50 сим.'],
            ['new_password_repeat', 'compare', 'compareAttribute' => $this->isNewRecord ? 'password' : 'new_password', 'when' => function ($model) {
                return empty($model->new_password) === false || empty($model->password) === false;
            }, 'skipOnEmpty' => false, 'message' => 'Пароли не совпадают'],
            ['role', 'roleExists', 'on' => 'profile',
                'when' => function ($model) {
                    return Yii::$app->user->can('users_crud');
                }
            ]
        ];
    }

    /**
     * Проверка наличия роли
     * @param $attribute
     * @param $params
     */
    public function roleExists($attribute, $params)
    {
        if (Yii::$app->authManager->getRole($this->$attribute) === null) {
            $this->addError($attribute, 'Такой роли не существует');
        }
    }

    /**
     * Проверяем старый пароль
     * @param $attribute
     * @param $params
     */
    public function isOldPassword($attribute, $params)
    {
        if (!Yii::$app->security->validatePassword($this->old_password, Yii::$app->user->identity->password)) {
            $this->addError('old_password', 'Неверный старый пароль');
        }
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
            'time_total' => 'Время на сайте',
            'ip' => 'IP адрес',
            'ua' => 'User Agent',
            'role' => 'Роль',
            'old_password' => 'Старый пароль',
            'new_password' => 'Новый пароль',
            'new_password_repeat' => 'Повторите пароль',
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
     * Получаем все роли
     * @return array
     */
    public static function getRoles()
    {
        if (self::$roles) {
            return self::$roles;
        }

        self::$roles = ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
        return self::$roles;
    }

    /**
     * Сохраняем роль пользователя
     */
    private function saveRole()
    {
        $auth = Yii::$app->authManager;
        $auth->revokeAll($this->id);

        if (($role = $auth->getRole($this->role)) !== null) {
            $auth->assign($role, $this->id);
        }
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
            $this->time_total = 0;
            $this->ip = Yii::$app->request->getUserIP();
            $this->ua = Yii::$app->request->getUserAgent();
        } elseif ($this->isNewRecord === false && $this->new_password) {
            $this->password = Yii::$app->security->generatePasswordHash($this->new_password);
        }

        $this->login = Html::encode($this->login);
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($this->scenario === self::SCENARIO_PROFILE) {
            $this->saveRole();
        }
        parent::afterSave($insert, $changedAttributes);
    }
}