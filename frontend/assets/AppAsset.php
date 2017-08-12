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
        'css/toastr.css',
        'css/site.css',
    ];
    public $js = [
        'js/bootstrap.min.js',
        'js/toastr.min.js',
        'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        '\traversient\yii\customscrollbar\AssetBundle'
    ];
}
