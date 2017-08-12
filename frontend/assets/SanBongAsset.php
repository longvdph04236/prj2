<?php
/**
 * Created by PhpStorm.
 * User: Jessie Sam
 * Date: 10/08/2017
 * Time: 12:34 CH
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class SanBongAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/sanbong.css',
    ];
    public $js = [
    ];
    public $depends = [
        'frontend\assets\AppAsset'
    ];
}