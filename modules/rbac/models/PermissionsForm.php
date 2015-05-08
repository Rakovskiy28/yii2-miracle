<?php

namespace modules\rbac\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 *
 * @property string $name
 * @property string $rule
 */
class PermissionsForm extends Model
{
    const SCENARIO_UPDATE = 'update';

    /**
     * Название права
     * @var string
     */
    public $name;

    /**
     * Алиас права
     * @var string
     */
    public $rule;

    /**
     * Предыдущий алиас права
     * @var string
     */
    public $last_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'rule'], 'required'],
            [['name', 'rule'], 'string', 'max' => 50],
            [['rule'], 'isUnique'],
        ];
    }

    /**
     * @param string $attribute
     * @param array $params
     */
    public function isUnique($attribute, $params)
    {
        if ($this->last_name != $this->$attribute && Yii::$app->authManager->getPermission($this->$attribute) != null) {
            $this->addError($attribute, 'Такое право уже существует');
        }
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['name', 'rule'],
            self::SCENARIO_UPDATE => ['name', 'rule'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Описание',
            'rule' => 'Алиас'
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterValidate()
    {
        if (parent::hasErrors() === false) {
            $this->savePermission();
        }
        parent::afterValidate();
    }

    /**
     * Сохраняем право
     * @return void
     */
    private function savePermission()
    {
        $auth = Yii::$app->authManager;

        if ($this->scenario == self::SCENARIO_UPDATE) {
            $permission = $auth->getPermission($this->last_name);
            $permission->description = $this->name;
            $auth->update($this->last_name, $permission);
        } else {
            $permission = $auth->createPermission($this->rule);
            $permission->description = $this->name;
            $auth->add($permission);
        }
    }
}