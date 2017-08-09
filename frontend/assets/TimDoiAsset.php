<?php
   namespace frontend\assets;

  Use yii\web\AssetBundle;

  class TimDoiAsset extends AssetBundle {
      public $basePath = '@webroot';
      public $baseUrl = '@web';
      public $css = [
          'css/timdoi.css',
      ];
      public $js = [
      ];
      public $depends = [
          'yii\web\YiiAsset',
      ];
  }
?>