<?php

namespace backend\components;

use Yii;
use yii\filters\AccessControl;

/**
 * Class Controller
 * @package backend\components
 */
class Controller extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['backend_access']
                    ]
                ],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function init(){
        $this->layout = Yii::$app->user->isGuest || Yii::$app->user->can('backend_access') === false ? 'login' : 'main';
        parent::init();
    }
}