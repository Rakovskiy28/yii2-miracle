<?php

namespace backend\components;

class Module extends \yii\base\Module
{
    /**
     * @var bool
     */
    public $isBackend = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->isBackend === true) {
            $this->setViewPath('@modules/' . $this->id . '/views/backend');
            $this->setLayoutPath('@backend/views/layouts');
            $this->controllerNamespace = $this->controllerNamespace === null ?
                '\modules\\' . $this->id . '\controllers\backend' : $this->controllerNamespace;
        } else {
            $this->setViewPath('@modules/' . $this->id . '/views/frontend');
            $this->setLayoutPath('@frontend/views/layouts');
            $this->controllerNamespace = $this->controllerNamespace === null ?
                '\modules\\' . $this->id . '\controllers\frontend' : $this->controllerNamespace;
        }
    }
}
