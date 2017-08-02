<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class HomeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/home.css',
        'css/responsive-main.css',
    ];
    public $js = [
        'js/jquery.mb.YTPlayer.js'
    ];
    public $depends = [
    ];
    public $jsOptions = [
        'async' => 'async',
    ];
}
