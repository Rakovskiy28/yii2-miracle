<?php

namespace common\rbac\rules;

use Yii;
use yii\rbac\Rule;

class Author extends Rule{

    /**
     * @var string
     */
    public $name = 'Author';

    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        return isset($params['id']) ? Yii::$app->user->id == $params['id'] : true;
    }

}