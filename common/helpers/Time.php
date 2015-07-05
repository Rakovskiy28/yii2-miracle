<?php

namespace common\helpers;

/**
 * Class Time
 * @package common\helpers
 */
class Time
{
    /**
     * @return mixed
     */
    public static function real()
    {
        return $_SERVER['REQUEST_TIME'];
    }
}