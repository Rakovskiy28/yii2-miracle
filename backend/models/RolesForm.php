<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

class RolesForm extends Model
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
    public $alias;

    /**
     * Предыдущий алиас редактируемой роли
     * @var string
     */
    public $last_name;

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
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'alias'], 'required'],
            [['name', 'alias'], 'string', 'max' => 50],
            [['alias'], 'uniqueRoles'],
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
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['update'] = ['name', 'alias', 'permissions', 'child_roles'];
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
        $auth = Yii::$app->authManager;

        if ($this->scenario == 'update') {
            $role = $auth->getRole($this->last_name);
            $role->name = $this->alias;
            $role->description = $this->name;
            $auth->update($this->last_name, $role);
        } else {
            $role = $auth->createRole($this->alias);
            $role->description = $this->name;
            $auth->add($role);
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

        static::getChild($this->alias);
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($this->alias);
        $auth->removeChildren($role);

        foreach ($this->permissions as $key => $item) {
            if (($permission = $auth->getPermission($item)) != null) {
                $auth->addChild($role, $permission);
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

        static::getChild($this->alias);
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($this->alias);

        foreach ($this->child_roles as $key => $item) {
            if (($child = $auth->getRole($item)) != null) {
                $auth->addChild($role, $child);
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
            $auth = Yii::$app->authManager;
            self::$child = $auth->getChildren($id);
        }
    }
}
