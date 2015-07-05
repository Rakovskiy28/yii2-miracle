<?php

namespace modules\users;

/**
 * Class Module
 * @package modules\users
 */
class Module extends \common\components\Module
{
    /**
     * Путь для сохранения файлов (аватарок)
     * @var string
     */
    public $filePath = '@files/users/avatars/';
    /**
     * URL директории с аватарками
     * @var string
     */
    public $fileUrl = '@urlFiles/users/avatars/';
}