<?php

namespace modules\users\models\frontend;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use modules\users\models\frontend\Users;

/**
 * Class UsersSearch
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
class UsersSearch extends Users
{
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
    public function rules()
    {
        return [
            ['sex', 'in', 'range' => ['m', 'w'], 'message' => 'Укажите пол.'],
            [['login', 'avatar'], 'safe'],
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
            $query->andFilterWhere(['!=', 'avatar', '0']);
        }

        $query->andFilterWhere([
            'id' => $this->id
        ]);

        $query->andFilterWhere([
            'sex' => $this->sex
        ]);

        $query->andFilterWhere(['like', 'login', $this->login]);

        return $dataProvider;
    }
}
