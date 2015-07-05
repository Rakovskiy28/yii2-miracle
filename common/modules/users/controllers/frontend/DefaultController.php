<?php

namespace modules\users\controllers\frontend;

use Yii;
use frontend\components\Controller;
use yii\web\NotFoundHttpException;
use modules\users\models\frontend\Users;
use modules\users\models\frontend\UsersSearch;

class DefaultController extends Controller
{
    /**
     * Выводим всех пользователей
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Профиль пользователя
     * @return string
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    /**
     * Получаем данные пользователя, если не найден возвращаем 404 ошибку
     * @param integer $id
     * @return \modules\users\models\frontend\Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (Yii::$app->user->id == $id) {
            return Yii::$app->user->identity;
        }

        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Пользователь не найден');
        }
    }
}