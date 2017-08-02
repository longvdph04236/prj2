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
        'css/home.css'
    ];
    public $js = [
        'js/jquery.mb.YTPlayer.js',
        'js/configYT.js'
    ];
    public $depends = [
    ];
    public $jsOptions = [
        'async' => 'async',
    ];
}
