<?php

namespace modules\users\models\frontend;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use modules\users\models\frontend\Users;

/**
 * Class UsersSearch
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
class UsersSearch extends Users
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        // Todo Переписать везде под префиксы
        // Todo Дописать поле аватар
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['avatar'], 'integer'],
            [['login'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Создаем критерии поиска
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Users::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->avatar){
            $query->andFilterWhere('avatar NOT NULL');
        }

        $query->andFilterWhere([
            'id' => $this->id
        ]);

        $query->andFilterWhere(['like', 'login', $this->login]);

        return $dataProvider;
    }
}
