<?php

namespace modules\users;

class Module extends \yii\base\Module
{
    public $isBackend;

    public function init()
    {
        parent::init();

        if ($this->isBackend === true) {
            $this->setViewPath('@modules/users/views/backend');
            $this->setLayoutPath('@backend/views/layouts');
        } else {
            $this->setViewPath('@modules/users/views/frontend');
            $this->setLayoutPath('@frontend/views/layouts');
        }
    }
}
