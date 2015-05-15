<?php

namespace backend\components;

use Yii;
use yii\filters\AccessControl;

class Controller extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function init(){
        $this->layout = Yii::$app->user->isGuest ? 'login' : 'main';
        parent::init();
    }
}