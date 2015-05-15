<?php

namespace themes\sb_admin\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $sourcePath = '@themes/sb_admin/assets';
    public $css = [
        'css/main.css',
        'css/sb-admin.css',
    ];
    public $js = [];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset'
    ];
}
