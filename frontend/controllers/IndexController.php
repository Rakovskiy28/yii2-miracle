<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Users;
use frontend\models\LoginForm;
use yii\filters\AccessControl;
use yii\helpers;
use yii\widgets\Menu;

class IndexController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionExit()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRegistration()
    {
        $model = new Users();
        $model->scenario = 'reg';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/']);
        }

        return $this->render('registration/index', [
            'model' => $model
        ]);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'registration', 'exit'],
                'rules' => [
                    [
                        'actions' => ['login', 'registration'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => ['exit'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ]
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'height' => 20,
                'width' => 90,
                'padding' => 0,
                'offset' => 3,
                'transparent' => true
            ],
        ];
    }
}
