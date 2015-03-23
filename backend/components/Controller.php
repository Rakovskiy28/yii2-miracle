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
                        'roles' => ['@'],
                    ]
                ],
            ]
        ];
    }

    public function beforeAction($action)
    {
        /*if (Yii::$app->user->getIsGuest() === false){
            $user = Yii::$app->user->identity;
            $user->updateUserData();
        }*/
        return parent::beforeAction($action);
    }
}