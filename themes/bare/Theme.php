<?php

namespace themes\bare;

use Yii;
use yii\helpers\Html;

class Theme extends \yii\base\Theme
{
    /**
     * @inheritdoc
     */
    public $pathMap = [
        '@frontend/views' => '@themes/bare/views',
        '@modules' => '@themes/bare/modules'
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }
}
