<?php

namespace modules\users;

use yii\base\BootstrapInterface;
use Yii;

/**
 * Class Bootstrap
 * @package modules\users
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $rules = [];
        $rules['login'] = 'users/guest/login';
        $rules['logout'] = 'users/user/logout';
        $rules['users/<id:\d+>'] = 'users/default/view';

        if (Yii::$app->id == 'app-backend') {
            $rules['users/create'] = 'users/default/create';
            $rules['users/update/<id:\d+>'] = 'users/default/update';
            $rules['users/delete/<id:\d+>'] = 'users/default/delete';
        } else {
            $rules['registration'] = 'users/guest/registration';
            $rules['users/update'] = 'users/user/update';
            $rules['users/delete-avatar'] = '/users/user/delete-avatar';
        }

        $app->urlManager->addRules($rules, false);
    }
}
