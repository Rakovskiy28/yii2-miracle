<?php

namespace backend\controllers;

use Yii;
use backend\models\RulesForm;
use backend\components\Controller;
use yii\data\ArrayDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\helpers\ArrayHelper;

class RulesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'delete-multiple' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['rules_view'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'delete', 'delete-multiple'],
                        'roles' => ['rules_crud'],
                    ]
                ],
            ]
        ]);
    }

    /**
     * Вывод всех правил
     * @return mixed
     */
    public function actionIndex()
    {
        $data = Yii::$app->authManager->getRules();
        $dataProvider = new ArrayDataProvider([
            'models' => $data,
            'totalCount' => count($data)
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Создание правила
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RulesForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Удаление правила
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException если нет такого правила
     */
    public function actionDelete($id)
    {
        $auth = Yii::$app->authManager;
        if (($rule = $auth->getRule($id)) != null) {
            $auth->remove($rule);
        } else {
            throw new NotFoundHttpException('Правило не найдена');
        }

        return $this->redirect(['index']);
    }

    /**
     * Массовое удаление правил
     * @return mixed
     */
    public function actionDeleteMultiple()
    {
        $auth = Yii::$app->authManager;
        $selection = Yii::$app->request->post('selection', []);

        foreach ($selection as $rule) {
            if (($rule = $auth->getRule($rule)) != null) {
                $auth->remove($rule);
            }
        }

        return $this->redirect(['index']);
    }
}
