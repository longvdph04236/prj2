<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class DanhSachSanAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/danhsachsan.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
