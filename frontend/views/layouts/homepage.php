<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use frontend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="full-screen">
    <div class="bg-full-screen"></div>
    <header class="transparent-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12 clearfix">
                    <div class="center-logo">
                        <a href="#"><img src="<?= Yii::getAlias('@web')?>/img/logo.png" alt=""></a>
                    </div>
                    <div class="pull-left">
                        <nav id="main-nav">
                            <ul class="clearfix">
                                <li><a href="<?= Url::toRoute('home/') ?>">Trang chủ</a></li>
                                <li><a href="<?= Url::toRoute('danh-sach-san/') ?>">Danh sách sân</a></li>
                                <li><a href="<?= Url::toRoute('tim-doi/') ?>">Tìm đối</a></li>
                                <li><a href="<?= Url::toRoute('ve-chung-toi/') ?>">Về chúng tôi</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="pull-right">
                        <ul id="right-nav" class="clearfix">
                            <li><a href="<?= Url::toRoute('dang-ky/') ?>"><i class="fa fa-user-plus"></i> Đăng ký</a></li>
                            <li><a href="<?= Url::toRoute('dang-nhap/') ?>"><i class="fa fa-sign-in"></i> Đăng nhập</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">Welcome</h2>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="text-center">
                        Copyright &copy; www.yeubongda.com. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
