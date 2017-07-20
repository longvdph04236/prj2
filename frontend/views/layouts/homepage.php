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
            <div class="row">
                <div class="col-md-12 three">
                    <div class="tab" role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#by-time" aria-controls="home" role="tab" data-toggle="tab">Tìm kiếm theo giờ</a></li>
                            <li role="presentation"><a href="#by-name" aria-controls="home" role="tab" data-toggle="tab">Tìm kiếm theo tên</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabs">
                            <div role="tabpanel" class="tab-pane fade in active" id="by-time">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input class="form-control" type="date" name="date">
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="city">
                                            <option value="0">Thành phố</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="city">
                                            <option value="0">Quận/huyện</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="by-name">
                                <p>Name abc</p>
                            </div>
                        </div>
                    </div>
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
