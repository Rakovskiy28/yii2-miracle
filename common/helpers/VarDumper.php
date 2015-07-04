<?php

namespace common\helpers;

class VarDumper extends \yii\helpers\VarDumper
{
    /**
     * @inheritdoc
     */
    public static function dump($var, $depth = 10, $highlight = true)
    {
        echo self::dumpAsString($var, $depth, $highlight);
    }
}