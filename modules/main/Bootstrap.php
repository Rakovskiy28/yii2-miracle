<?php

namespace modules\main;

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
                '' => 'main/default/index'
            ],
            false
        );
    }
}
