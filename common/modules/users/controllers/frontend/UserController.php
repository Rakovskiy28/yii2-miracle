<?php

namespace modules\users\controllers\frontend;

use Yii;
use frontend\components\Controller;
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
                        'roles' => ['@'],
                    ]
                ],
            ]
        ];
    }

    /**
     * Настройки личного профиля
     * @return string
     */
    public function actionUpdate()
    {
        $model = Yii::$app->user->identity;
        $model->scenario = $model::SCENARIO_PROFILE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/users/default/view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Удаление аватара
     * @return \yii\web\Response
     */
    public function actionDeleteAvatar()
    {
        $model = Yii::$app->user->identity->deleteAvatar(true);
        return $this->redirect(['/users/user/update']);
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
