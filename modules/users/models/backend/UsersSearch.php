<?php

namespace modules\users\models\backend;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use modules\users\models\backend\Users;

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
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
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

        $query->andFilterWhere([
            'id' => $this->id
        ]);

        $query->andFilterWhere(['like', 'login', $this->login]);

        return $dataProvider;
    }
}
