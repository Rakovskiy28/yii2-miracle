<?php

namespace backend\controllers;

use Yii;
use backend\components\Controller;
use backend\models\LoginForm;
use yii\filters\AccessControl;

class IndexController extends Controller
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
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['admin_access']
                    ],
                    [
                        'actions' => ['exit'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => ['captcha'],
                        'allow' => true
                    ],
                ],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'height' => 20,
                'width' => 90,
                'padding' => 0,
                'offset' => 3,
                'transparent' => true
            ]
        ];
    }

    /**
     * Главная страница админки
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Авторизация
     * @return string
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/']);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Выход
     * @return \yii\web\Response
     */
    public function actionExit()
    {
        Yii::$app->user->logout();

        return $this->redirect(['']);
    }

}