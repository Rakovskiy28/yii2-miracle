<?php

namespace modules\rbac\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class PermissionsForm
 * @package modules\rbac\models
 */
class RolesForm extends Model
{
    /**
     * Сценарий редактирования
     */
    const SCENARIO_UPDATE = 'update';

    /**
     * Название роли
     * @var string
     */
    public $name;

    /**
     * Алиас роли
     * @var string
     */
    public $alias;

    /**
     * Предыдущий алиас роли
     * @var string
     */
    public $last_name;

    /**
     * Правило для роли
     * @var string
     */
    public $rule;

    /**
     * Массив прав доступа
     * @var array
     */
    public $permissions = [];

    /**
     * @var array
     */
    public $child_roles = [];

    /**
     * Родители роли
     * @var string
     */
    private static $child;

    /**
     * @var object
     */
    private static $_auth;

    /**
     * @inheritdoc
     */
    public function init()
    {
        self::$_auth = Yii::$app->authManager;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'alias'], 'required'],
            [['name', 'alias'], 'string', 'max' => 50],
            [['alias'], 'uniqueRoles'],
            [['rule'], 'existsRule'],
            [['permissions', 'child_roles'], 'safe']
        ];
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function uniqueRoles($attribute, $params)
    {
        if ($this->last_name != $this->$attribute && Yii::$app->authManager->getRole($this->$attribute) != null) {
            $this->addError($attribute, 'Такая роль уже существует');
        }
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function existsRule($attribute, $params)
    {
        if ($this->$attribute !== false && self::$_auth->getRule($this->$attribute) === null) {
            $this->addError($attribute, 'Такое правило не существует');
        }
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_UPDATE] = ['name', 'alias', 'permissions', 'child_roles', 'rule'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'alias' => 'Алиас',
            'rule' => 'Правило',
            'permissions' => 'Права доступа',
            'child_roles' => 'Дочерние роли'
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterValidate()
    {
        if (parent::hasErrors() === false) {
            $this->saveRole();
        }
        parent::afterValidate();
    }

    /**
     * Сохраняем роль
     * @return void
     */
    private function saveRole()
    {
        if ($this->scenario == self::SCENARIO_UPDATE) {
            $role = self::$_auth->getRole($this->last_name);
            $role->name = $this->alias;
            $role->description = $this->name;
            $role->ruleName = $this->rule;
            self::$_auth->update($this->last_name, $role);
        } else {
            $role = self::$_auth->createRole($this->alias);
            $role->description = $this->name;
            $role->ruleName = $this->rule;
            self::$_auth->add($role);
        }

        $this->savePermissions();
        $this->saveChildRoles();
    }

    /**
     * Получаем права доступа
     * @return array
     */
    public function getPermissions()
    {
        return ArrayHelper::map(Yii::$app->authManager->getPermissions(), 'name', 'description');
    }

    /**
     * Получаем роли доступа
     * @return array
     */
    public function getRules()
    {
        $rules = [
            '' => 'Не выбрано'
        ];
        return ArrayHelper::merge(
            $rules,
            ArrayHelper::map(Yii::$app->authManager->getRules(), 'name', 'name')
        );
    }

    /**
     * Получаем роли
     * @return array
     */
    public function getRoles($id)
    {
        $roles = ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
        unset($roles[$id]);
        return $roles;
    }

    /**
     * Сохраняем правила для текущей роли
     * @return void
     */
    private function savePermissions()
    {
        if (is_array($this->permissions) === false) {
            $this->permissions = [];
        }

        self::getChild($this->alias);
        $role = self::$_auth->getRole($this->alias);
        self::$_auth->removeChildren($role);

        foreach ($this->permissions as $key => $item) {
            if (($permission = self::$_auth->getPermission($item)) != null) {
                self::$_auth->addChild($role, $permission);
            }
        }
    }

    /**
     * Сохраняем дочерние роли
     * @return void
     */
    private function saveChildRoles()
    {
        if (is_array($this->child_roles) === false) {
            $this->child_roles = [];
        }

        self::getChild($this->alias);
        $role = self::$_auth->getRole($this->alias);

        foreach ($this->child_roles as $key => $item) {
            if (($child = self::$_auth->getRole($item)) != null) {
                self::$_auth->addChild($role, $child);
            }
        }
    }

    /**
     * Проверяем, является ли правило $value дочерним для роли $id
     * @param string $id
     * @param string $value
     * @return bool
     */
    public function isChild($id, $value)
    {
        self::getChild($id);
        return isset(self::$child[$value]);
    }

    /**
     * Получаем дочерние правила для роли $id
     * @param string $id
     */
    private static function getChild($id)
    {
        if (is_array(self::$child) === false) {
            self::$_auth = Yii::$app->authManager;
            self::$child = self::$_auth->getChildren($id);
        }
    }
}
