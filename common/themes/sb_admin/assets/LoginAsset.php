<?php

namespace themes\sb_admin\assets;

use yii\web\AssetBundle;

class LoginAsset extends AssetBundle
{
    public $sourcePath = '@themes/sb_admin/assets';
    public $css = [
        'css/login.css'
    ];
    public $js = [];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}
