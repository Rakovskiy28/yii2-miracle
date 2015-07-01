<?php

namespace modules\users\controllers\frontend;

use Yii;
use modules\users\models\frontend\LoginForm;
use frontend\components\Controller;
use yii\filters\AccessControl;
use modules\users\models\frontend\Users;

class GuestController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'registration'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ]
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
     * Регистрация
     * @return string
     */
    public function actionRegistration()
    {
        $model = new Users();
        $model->scenario = $model::SCENARIO_REGISTRATION;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/']);
        } else {
            return $this->render('registration', [
                'model' => $model,
            ]);
        }
    }
}
