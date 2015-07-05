<?php

namespace modules\rbac\data\rules;

use Yii;
use yii\rbac\Rule;

/**
 * Class Author
 * @package modules\rbac\data\rules
 */
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