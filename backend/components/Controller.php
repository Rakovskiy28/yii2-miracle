<?php

namespace backend\components;

use Yii;
use yii\filters\AccessControl;

class Controller extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function init(){
        $this->layout = Yii::$app->user->isGuest ? 'login' : 'main';
        parent::init();
    }
}