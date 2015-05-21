<?php

namespace themes\sb_admin\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $sourcePath = '@themes/sb_admin/assets';
    public $css = [
        'css/bootstrap.min.css',
        'css/sb-admin.css',
        'font-awesome/css/font-awesome.min.css'
    ];
    public $js = [
        'js/bootstrap.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
