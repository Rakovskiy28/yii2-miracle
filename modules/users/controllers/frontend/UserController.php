<?php

namespace modules\users\controllers\frontend;

use Yii;
use backend\components\Controller;
use yii\filters\AccessControl;

class UserController extends Controller
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
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ]
                ],
            ]
        ];
    }

    /**
     * Выход
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['/']);
    }
}
