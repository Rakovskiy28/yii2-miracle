<?php

namespace modules\rbac;

class Module extends \yii\base\Module
{
    public $isBackend;

    public function init()
    {
        parent::init();

        if ($this->isBackend === true) {
            $this->setViewPath('@modules/rbac/views/backend');
            $this->setLayoutPath('@backend/views/layouts');
        } else {
            $this->setViewPath('@modules/rbac/views/frontend');
            $this->setLayoutPath('@frontend/views/layouts');
        }
    }
}
