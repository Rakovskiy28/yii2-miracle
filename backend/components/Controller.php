<?php

namespace backend\components;

use Yii;
use yii\filters\AccessControl;

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
                        'roles' => ['admin_access'],
                    ]
                ],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function init(){
        $this->layout = Yii::$app->user->getIsGuest() ? 'login' : 'main';
        parent::init();
    }
}