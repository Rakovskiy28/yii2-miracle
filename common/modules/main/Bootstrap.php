<?php

namespace modules\main;

use yii\base\BootstrapInterface;

/**
 * Class Bootstrap
 * @package modules\main
 */
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
