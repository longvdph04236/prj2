<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        'css/font-awesome.css',
        'https://fonts.googleapis.com/css?family=Lobster&amp;subset=vietnamese',
        'css/site.css',
    ];
    public $js = [
        'js/bootstrap.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
