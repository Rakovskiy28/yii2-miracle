<?php

namespace modules\users;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->urlManager->addRules(
            [
                'login' => 'users/guest/login',
                'logout' => 'users/user/logout',
                'users/create' => 'users/default/create',
                'users/<id:\d+>' => 'users/default/view',
                'users/update/<id:\d+>' => 'users/default/update',
                'users/delete/<id:\d+>' => 'users/default/delete',
            ],
            false
        );
    }
}
