<?php

namespace backend\models;

use Yii;
use yii\base\Model;

/**
 *
 * @property string $name
 * @property string $rule
 */
class PermissionsForm extends Model
{
    /**
     * Название роли
     * @var string
     */
    public $name;

    /**
     * Алиас роли
     * @var string
     */
    public $rule;

    /**
     * Предыдущий алиас редактируемой роли
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
            [['rule'], 'uniqueRule'],
        ];
    }

    /**
     * @param string $attribute
     * @param array $params
     */
    public function uniqueRule($attribute, $params)
    {
        if ($this->last_name != $this->$attribute && Yii::$app->authManager->getPermission($this->$attribute) != null) {
            $this->addError($attribute, 'Такое правило уже существует');
        }
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['update'] = ['name', 'rule'];
        return $scenarios;
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
     * Сохраняем роль
     * @return void
     */
    private function savePermission()
    {
        $auth = Yii::$app->authManager;

        if ($this->scenario == 'update') {
            $permission = $auth->getPermission($this->last_name);
            $permission->name = $this->rule;
            $permission->description = $this->name;
            $auth->update($this->last_name, $permission);
        } else {
            $permission = $auth->createPermission($this->rule);
            $permission->description = $this->name;
            $auth->add($permission);
        }
    }
}