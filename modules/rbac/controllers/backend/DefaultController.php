<?php

namespace modules\rbac\controllers\backend;

use common\components\VarDumper;
use Yii;
use modules\rbac\models\PermissionsForm;
use backend\components\Controller;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class DefaultController extends Controller
{
    /**
     * Права доступа по умолчанию, которые нельзя удалить
     * @var array
     */
    private $default = [
        'permissions_crud',
        'permissions_view',
        'roles_crud',
        'roles_view',
    ];

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
                        'roles' => ['permissions_view'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete', 'delete-multiple'],
                        'roles' => ['permissions_crud'],
                    ]
                ],
            ]
        ]);
    }

    /**
     * Вывод всех прав доступа
     * @return mixed
     */
    public function actionIndex()
    {
        $data = Yii::$app->authManager->getPermissions();
        $dataProvider = new ArrayDataProvider([
            'models' => $data,
            'totalCount' => count($data),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Создание нового правила
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PermissionsForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Изменение правила
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findPermission($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Удаление правила
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException если нет такой роли
     */
    public function actionDelete($id)
    {
        if (in_array($id, $this->default)) {
            throw new ForbiddenHttpException('Данное правило по умолчанию, все действия запрещены.');
        }

        $auth = Yii::$app->authManager;
        if (($rule = $auth->getPermission($id)) != null) {
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
            if (($rule = $auth->getPermission($rule)) != null && in_array($rule->name, $this->default) === false) {
                $auth->remove($rule);
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Поиск правила, если не найдена возвращаем 404 ошибку
     * @param integer $id
     * @return object
     * @throws NotFoundHttpException если нет такой роли
     * @throws ForbiddenHttpException
     */
    protected function findPermission($id)
    {
        if (in_array($id, $this->default)) {
            throw new ForbiddenHttpException('Данное правило по умолчанию, все действия запрещены.');
        }

        if (($rule = Yii::$app->authManager->getPermission($id)) !== null) {
            $model = new PermissionsForm(['scenario' => 'update']);
            $model->name = $rule->description;
            $model->rule = $rule->name;
            $model->last_name = $rule->name;
            return $model;
        } else {
            throw new NotFoundHttpException('Роль не найдена');
        }
    }

}
