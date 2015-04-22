<?php

namespace common\rbac\rules;

use Yii;
use yii\rbac\Rule;

class Author extends Rule{

    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        if (Yii::$app->user->isGuest || isset($params['id']) === false){
            return false;
        }

        return Yii::$app->user->id == $params['id'];
    }

}