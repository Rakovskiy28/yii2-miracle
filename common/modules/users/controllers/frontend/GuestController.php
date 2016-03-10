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
                'height' => 22,
                'width' => 120,
                'padding' => -2,
                'offset' => 5,
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
        $model->scenario = Users::SCENARIO_REGISTRATION;

        if ($model->load(Yii::$app->request->post()) && $model->save() && Yii::$app->user->login($model)) {
            return $this->redirect(['/']);
        } else {
            return $this->render('registration', [
                'model' => $model,
            ]);
        }
    }
}
