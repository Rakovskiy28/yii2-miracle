<?php

namespace modules\main\controllers\frontend;

use Yii;
use yii\web\Controller;

/**
 * Class DefaultController
 * @package modules\main\controllers\frontend
 */
class DefaultController extends Controller
{
    /**
     * Главная страница
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}