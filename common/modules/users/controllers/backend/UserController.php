<?php

namespace modules\users\controllers\backend;

use Yii;
use modules\users\models\backend\LoginForm;
use backend\components\Controller;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
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
        ]);
    }

    /**
     * Выход
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['']);
    }
}
